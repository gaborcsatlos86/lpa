<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use App\Enums\{UserLevel, AnswerTypes};
use App\Entity\Area;
use App\Entity\{QuestionAnswer, AnswerSummary};
use \DateTimeImmutable;
use \Exception;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'app:answer-summary-update')]
class AnswerSummaryUpdateCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em,
        private ParameterBagInterface $params
    ) {
        parent::__construct(null);
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $areas = $this->em->getRepository(Area::class)->findAll();
            foreach ($areas as $area) {
                foreach (UserLevel::getItems() as $level) {
                    if (!$this->processAnswers($area, $level)) {
                        break;
                    }
                }
            }
        } catch (Exception $e) {
            var_dump($e, $e->getMessage());
            return Command::INVALID;
        }
        
        return Command::SUCCESS;
    }
    
    
    protected function processAnswers(Area $area, string $level): bool
    {
        $answers = $this->em->getRepository(QuestionAnswer::class)->findBy(['area' => $area, 'level' => $level]);
        foreach ($answers as $questionAnswer) {
            /** @var QuestionAnswer $questionAnswer */
            $answerSummaryRes = $this->findByAnswer($questionAnswer);
            if (empty($answerSummaryRes)) {
                $answerSummary = (new AnswerSummary)
                    ->setLevel($level)
                    ->setArea($area)
                    ->setTableGroup($questionAnswer->getTableGroup())
                    ->setProduct($questionAnswer->getProduct())
                    ->setAnswer($questionAnswer->getAnswer())
                ;
                if ($questionAnswer->getAnswer() == AnswerTypes::ANSWER_CORR) {
                    $answerSummary->increaseCorrNum();
                }
                $answerSummary->setPeriodStart($questionAnswer->getCreatedAt());
                $this->em->persist($answerSummary);
                if ($questionAnswer->getAnswerSummary() == null) {
                    $questionAnswer->setAnswerSummary($answerSummary);
                    $this->em->persist($questionAnswer);
                }
                $this->em->flush();
                continue;
            }
            if (is_array($answerSummaryRes) && count($answerSummaryRes) > 2) {
                throw new Exception(serialize($answerSummaryRes));
                return false;
            }
            $answerSummary = $answerSummaryRes[0];
            if ($answerSummary instanceof AnswerSummary) {
                if ($questionAnswer->getAnswer() == AnswerTypes::ANSWER_CORR) {
                    $answerSummary->increaseCorrNum();
                    switch ($level) {
                        case UserLevel::LEVEL_1:
                            if ($answerSummary->getCorrNum() >= 3 ) {
                                $answerSummary->setAnswer(AnswerTypes::ANSWER_NOK);
                            }
                            break;
                            
                        case UserLevel::LEVEL_2:
                            if ($answerSummary->getCorrNum() >= 2 ) {
                                $answerSummary->setAnswer(AnswerTypes::ANSWER_NOK);
                            }
                            break;
                            
                        case UserLevel::LEVEL_3:
                            if ($answerSummary->getCorrNum() >= 1 ) {
                                $answerSummary->setAnswer(AnswerTypes::ANSWER_NOK);
                            }
                            break;
                    }
                    $this->em->persist($answerSummary);
                }
                if ($questionAnswer->getAnswerSummary() == null) {
                    $questionAnswer->setAnswerSummary($answerSummary);
                    $this->em->persist($questionAnswer);
                }
            
                if (($answerSummary->getAnswer() != $questionAnswer->getAnswer()) && ($questionAnswer->getAnswer() == AnswerTypes::ANSWER_NOK)) {
                    $answerSummary->setAnswer($questionAnswer->getAnswer());
                    $this->em->persist($answerSummary);
                    
                }
                $this->em->flush();
            }
        }
        return true;
    }
    
    protected function calulateFirstAndLastDayOfWeek(AnswerSummary $answerSummary, DateTimeImmutable $createdAt): AnswerSummary
    {
        $periodStart = $periodEnd = $createdAt;
        $periodStart = $periodStart
            ->setISODate((int)$createdAt->format('Y'), (int)$createdAt->format('W'))
            ->setTime(0, 0, 0)
        ;
        $periodEnd = $periodEnd
            ->setISODate((int)$createdAt->format('Y'), (int)$createdAt->format('W'), 7)
            ->setTime(23, 59, 59)
        ;
        return $answerSummary
            ->setPeriodStart($periodStart)
            ->setPeriodEnd($periodEnd)
        ;
    }
    
    protected function findByAnswer(QuestionAnswer $answer): array|AnswerSummary
    {
        $qb = $this->em->getRepository(AnswerSummary::class)->createQueryBuilder('ansu')
            ->andWhere('ansu.area = :area')
            ->andWhere('ansu.level = :level')
            ->andWhere('ansu.tableGroup = :tableGroup')
            ->andWhere('ansu.product = :product')
            ->setParameter('area', $answer->getArea())
            ->setParameter('level', $answer->getLevel())
            ->setParameter('tableGroup', $answer->getTableGroup())
            ->setParameter('product', $answer->getProduct());
        
        $qb = $qb->andWhere('ansu.periodStart LIKE :date');
        $qb = $qb->setParameter('date', $answer->getCreatedAt()->format('Y-m-d').'%');
        return $qb->getQuery()->getResult();
    }
    
}