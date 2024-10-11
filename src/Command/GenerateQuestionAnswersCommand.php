<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Enums\AnswerTypes;
use App\Entity\{User, Question, TableGroup, Product, QuestionAnswer};
use \DateTimeImmutable;


#[AsCommand(name: 'app:generate-question-answers')]
class GenerateQuestionAnswersCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
            parent::__construct(null);
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $questions = $this->em->getRepository(Question::class)->findAll();
        $users = $this->em->getRepository(User::class)->findAll();
        $tableGroup = $this->em->getRepository(TableGroup::class)->findBy([],[],1);
        $product = $this->em->getRepository(Product::class)->findBy([],[],1);
        
        for ($i=0; $i<10; $i++)
        {
            $date = (new \DateTimeImmutable())->modify('-'. $i . ' days');
            foreach ($questions as $question) {
                foreach ($users as $user) {
                    $answer = $this->randAnswer();
                    
                    $qa = (new QuestionAnswer())
                        ->setQuestion($question)
                        ->setUser($user)
                        ->setLevel($question->getLevel())
                        ->setArea($question->getArea())
                        ->setTableGroup($tableGroup[0])
                        ->setProduct($product[0])
                        ->setAnswer($answer)
                    ;
                    $this->em->persist($qa);
                    $this->em->flush();
                    $this->em->refresh($qa);
                    $qa->setCreatedAt($date);
                    $this->em->persist($qa);
                    $this->em->flush();
                }
            }
        }
        
        return Command::SUCCESS;
    }
    
    protected function randAnswer()
    {
        $items = array_values(AnswerTypes::getItems());
        return $items[array_rand($items, 1)];
    }
    
}