<?php

declare(strict_types=1);

namespace App\Block;

use App\Enums\{UserLevel, Area, AnswerTypes};
use App\Entity\{QuestionAnswer, Question};
use App\Entity\Area as AreaEntity;
use Sonata\AdminBundle\Admin\Pool;
use Symfony\Component\HttpFoundation\Response;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\QuestionAnswerRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;
use \DateTimeImmutable;

class QuestionAnswerStatisticsBlockService extends AbstractBlockService
{
    public function __construct(
        Environment $twig,
        private EntityManagerInterface $em,
        private QuestionAnswerRepositoryInterface $questionAnswerRepository,
        private Pool $pool,
        
    ) {
        parent::__construct($twig);
    }
    
    public function execute(BlockContextInterface $blockContext, ?Response $response = null): Response
    {
        // merge settings
        $settings = $blockContext->getSettings();
        $admin = $this->pool->getAdminByAdminCode($blockContext->getSetting('code'));
        $today = new DateTimeImmutable();
        $yesterday = new DateTimeImmutable('yesterday');
        
        $areas = $this->initAreas();
        
        $todayItems = $this->questionAnswerRepository->findByDate($today);
        $yesterdayItems = $this->questionAnswerRepository->findByDate($yesterday);
        $chart = $this->calculateChart($yesterday, $yesterdayItems, $areas);
        $chart = array_merge($chart, $this->calculateChart($today, $todayItems, $areas));
        
        

        return $this->renderResponse($blockContext->getTemplate(), [
            'chartFields'   => [
                'Yesterday' . '-' . UserLevel::LEVEL_1 . '-' . Area::AREA_PRODUCTION,
                'Yesterday' . '-' . UserLevel::LEVEL_1 . '-' . Area::AREA_WAREHOUSE,
                'Yesterday' . '-' . UserLevel::LEVEL_1 . '-' . Area::AREA_MAINTENANCE,
                'Yesterday' . '-' . UserLevel::LEVEL_2 . '-' . Area::AREA_PRODUCTION,
                'Yesterday' . '-' . UserLevel::LEVEL_2 . '-' . Area::AREA_WAREHOUSE,
                'Yesterday' . '-' . UserLevel::LEVEL_2 . '-' . Area::AREA_MAINTENANCE,
                'Yesterday' . '-' . UserLevel::LEVEL_3 . '-' . Area::AREA_PRODUCTION,
                'Yesterday' . '-' . UserLevel::LEVEL_3 . '-' . Area::AREA_WAREHOUSE,
                'Yesterday' . '-' . UserLevel::LEVEL_3 . '-' . Area::AREA_MAINTENANCE,
                'Today' . '-' . UserLevel::LEVEL_1 . '-' . Area::AREA_PRODUCTION,
                'Today' . '-' . UserLevel::LEVEL_1 . '-' . Area::AREA_WAREHOUSE,
                'Today' . '-' . UserLevel::LEVEL_1 . '-' . Area::AREA_MAINTENANCE,
                'Today' . '-' . UserLevel::LEVEL_2 . '-' . Area::AREA_PRODUCTION,
                'Today' . '-' . UserLevel::LEVEL_2 . '-' . Area::AREA_WAREHOUSE,
                'Today' . '-' . UserLevel::LEVEL_2 . '-' . Area::AREA_MAINTENANCE,
                'Today' . '-' . UserLevel::LEVEL_3 . '-' . Area::AREA_PRODUCTION,
                'Today' . '-' . UserLevel::LEVEL_3 . '-' . Area::AREA_WAREHOUSE,
                'Today' . '-' . UserLevel::LEVEL_3 . '-' . Area::AREA_MAINTENANCE,
            ],
            'chart'     => $chart,
            'tops'      => $this->getTops(),
            'block'     => $blockContext->getBlock(),
            'settings'  => $settings,
            'admin'     => $admin,
        ], $response);
    }
    
    public function configureSettings(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'icon' => 'fas fa-chart-line',
            'text' => 'Statistics',
            'translation_domain' => null,
            'color' => 'bg-aqua',
            'code' => false,
            'filters' => [],
            'limit' => 1000,
            'template' => 'admin/block/block_stats.html.twig',
        ]);
    }
    
    protected function initAreas(): array
    {
        $areas = [
            Area::AREA_PRODUCTION => [],
            Area::AREA_WAREHOUSE => [],
            Area::AREA_MAINTENANCE => [],
        ];
        
        $prods = $this->em->getRepository(AreaEntity::class)->findBy(['type' => Area::AREA_PRODUCTION]);
        foreach ($prods as $item) {
            $areas[Area::AREA_PRODUCTION][] = $item->getId();
        }
        
        $warehouses = $this->em->getRepository(AreaEntity::class)->findBy(['type' => Area::AREA_WAREHOUSE]);
        foreach ($warehouses as $item) {
            $areas[Area::AREA_WAREHOUSE][] = $item->getId();
        }
        
        $maintens = $this->em->getRepository(AreaEntity::class)->findBy(['type' => Area::AREA_MAINTENANCE]);
        foreach ($maintens as $item) {
            $areas[Area::AREA_MAINTENANCE][] = $item->getId();
        }
        
        return $areas;
    }
    
    protected function calculateChart(DateTimeImmutable $date, array $items, array $areas): array
    {
        $dateString = $date->format('Y-m-d');
        $chartData = [
            $dateString . '-' . UserLevel::LEVEL_1 . '-' . Area::AREA_PRODUCTION => 0,
            $dateString . '-' . UserLevel::LEVEL_1 . '-' . Area::AREA_WAREHOUSE => 0,
            $dateString . '-' . UserLevel::LEVEL_1 . '-' . Area::AREA_MAINTENANCE => 0,
            $dateString . '-' . UserLevel::LEVEL_2 . '-' . Area::AREA_PRODUCTION => 0,
            $dateString . '-' . UserLevel::LEVEL_2 . '-' . Area::AREA_WAREHOUSE => 0,
            $dateString . '-' . UserLevel::LEVEL_2 . '-' . Area::AREA_MAINTENANCE => 0,
            $dateString . '-' . UserLevel::LEVEL_3 . '-' . Area::AREA_PRODUCTION => 0,
            $dateString . '-' . UserLevel::LEVEL_3 . '-' . Area::AREA_WAREHOUSE => 0,
            $dateString . '-' . UserLevel::LEVEL_3 . '-' . Area::AREA_MAINTENANCE => 0,
        ];
        
        foreach ($items as $questionAnswer) {
            /** @var QuestionAnswer $questionAnswer */
            switch ($questionAnswer->getLevel()) {
                case UserLevel::LEVEL_1:
                    if (in_array($questionAnswer->getArea()->getId(), $areas[Area::AREA_PRODUCTION])) {$chartData[$dateString . '-' . UserLevel::LEVEL_1 . '-' . Area::AREA_PRODUCTION]++;}
                    if (in_array($questionAnswer->getArea()->getId(), $areas[Area::AREA_WAREHOUSE])) {$chartData[$dateString . '-' . UserLevel::LEVEL_1 . '-' . Area::AREA_WAREHOUSE]++;}
                    if (in_array($questionAnswer->getArea()->getId(), $areas[Area::AREA_MAINTENANCE])) {$chartData[$dateString . '-' . UserLevel::LEVEL_1 . '-' . Area::AREA_MAINTENANCE]++;}
                break;
                case UserLevel::LEVEL_2:
                    if (in_array($questionAnswer->getArea()->getId(), $areas[Area::AREA_PRODUCTION])) {$chartData[$dateString . '-' . UserLevel::LEVEL_2 . '-' . Area::AREA_PRODUCTION]++;}
                    if (in_array($questionAnswer->getArea()->getId(), $areas[Area::AREA_WAREHOUSE])) {$chartData[$dateString . '-' . UserLevel::LEVEL_2 . '-' . Area::AREA_WAREHOUSE]++;}
                    if (in_array($questionAnswer->getArea()->getId(), $areas[Area::AREA_MAINTENANCE])) {$chartData[$dateString . '-' . UserLevel::LEVEL_2 . '-' . Area::AREA_MAINTENANCE]++;}
                break;
                case UserLevel::LEVEL_3:
                    if (in_array($questionAnswer->getArea()->getId(), $areas[Area::AREA_PRODUCTION])) {$chartData[$dateString . '-' . UserLevel::LEVEL_3 . '-' . Area::AREA_PRODUCTION]++;}
                    if (in_array($questionAnswer->getArea()->getId(), $areas[Area::AREA_WAREHOUSE])) {$chartData[$dateString . '-' . UserLevel::LEVEL_3 . '-' . Area::AREA_WAREHOUSE]++;}
                    if (in_array($questionAnswer->getArea()->getId(), $areas[Area::AREA_MAINTENANCE])) {$chartData[$dateString . '-' . UserLevel::LEVEL_3 . '-' . Area::AREA_MAINTENANCE]++;}
            }
        }
        
        return $chartData;
    }
    
    protected function getTops(): array
    {
        $tops = [
            AnswerTypes::ANSWER_NOK => [],
            AnswerTypes::ANSWER_CORR => []
        ];
        $nokStmt = $this->em->getConnection()->prepare("SELECT COUNT(qa.id) as answerNum, qa.area_id, qa.question_id FROM question_answer qa WHERE qa.answer = '".AnswerTypes::ANSWER_NOK."' GROUP BY qa.area_id, qa.question_id ORDER BY answerNum DESC");
        $noks = $nokStmt->executeQuery()->fetchAllAssociative();
        
        $corrStmt = $this->em->getConnection()->prepare("SELECT COUNT(qa.id) as answerNum, qa.question_id FROM question_answer qa WHERE qa.answer = '".AnswerTypes::ANSWER_CORR."' GROUP BY qa.question_id ORDER BY answerNum DESC");
        $corrs = $corrStmt->executeQuery()->fetchAllAssociative();
        
        
        foreach ($noks as $nokAnswer) {
            if (!isset($tops[AnswerTypes::ANSWER_NOK][$nokAnswer['question_id']])) {
                $tops[AnswerTypes::ANSWER_NOK][$nokAnswer['question_id']] = [
                    'sum' => 0,
                    'byArea' => []
                ];
            }
            $tops[AnswerTypes::ANSWER_NOK][$nokAnswer['question_id']]['sum'] += $nokAnswer['answerNum'];
            if (!isset($tops[AnswerTypes::ANSWER_NOK][$nokAnswer['question_id']]['byArea'][$nokAnswer['area_id']])) {
                $tops[AnswerTypes::ANSWER_NOK][$nokAnswer['question_id']]['byArea'][$nokAnswer['area_id']] = 0;
            }
            $tops[AnswerTypes::ANSWER_NOK][$nokAnswer['question_id']]['byArea'][$nokAnswer['area_id']] += $nokAnswer['answerNum'];
        }
        
        foreach ($corrs as $corrAnswer) {
            if (!isset($tops[AnswerTypes::ANSWER_CORR][$corrAnswer['question_id']])) {
                $tops[AnswerTypes::ANSWER_CORR][$corrAnswer['question_id']] = [
                    'sum' => 0,
                ];
            }
            $tops[AnswerTypes::ANSWER_CORR][$corrAnswer['question_id']]['sum'] += $corrAnswer['answerNum'];
        }
        
        $topNok = $topCorr = [
            'top1' => [
                'value' => 0,
                'question' => null
            ],
            'top2' => [
                'value' => 0,
                'question' => null
            ],
            'top3' => [
                'value' => 0,
                'question' => null
            ],
        ];
        
        foreach ($tops[AnswerTypes::ANSWER_NOK] as $question_id => $nokData) {
            if ($nokData['sum'] > $topNok['top1']['value']) {
                $topNok['top3'] = $topNok['top2'];
                $topNok['top2'] = $topNok['top1'];
                $topNok['top1'] = [
                    'value' => $nokData['sum'],
                    'question' => $question_id,
                    'byArea' => $nokData['byArea']
                ];
            } elseif ($nokData['sum'] > $topNok['top2']['value']) {
                $topNok['top3'] = $topNok['top2'];
                $topNok['top2'] = [
                    'value' => $nokData['sum'],
                    'question' => $question_id,
                    'byArea' => $nokData['byArea']
                ];
            } elseif ($nokData['sum'] > $topNok['top3']['value']) {
                $topNok['top3'] = [
                    'value' => $nokData['sum'],
                    'question' => $question_id,
                    'byArea' => $nokData['byArea']
                ];
            }
        }
        foreach ($tops[AnswerTypes::ANSWER_CORR] as $question_id => $corrData) {
            if ($corrData['sum'] > $topCorr['top1']['value']) {
                $topCorr['top3'] = $topCorr['top2'];
                $topCorr['top2'] = $topCorr['top1'];
                $topCorr['top1'] = [
                    'value' => $corrData['sum'],
                    'question' => $question_id
                ];
            } elseif ($corrData['sum'] > $topCorr['top2']['value']) {
                $topCorr['top3'] = $topCorr['top2'];
                $topCorr['top2'] = [
                    'value' => $corrData['sum'],
                    'question' => $question_id
                ];
            } elseif ($corrData['sum'] > $topCorr['top3']['value']) {
                $topCorr['top3'] = [
                    'value' => $corrData['sum'],
                    'question' => $question_id
                ];
            }
        }
        if (isset($topNok['top1']['question'])) {
            $topNok['top1']['question'] = $this->em->getRepository(Question::class)->find($topNok['top1']['question']);
        }
        if (isset($topNok['top2']['question'])) {
            $topNok['top2']['question'] = $this->em->getRepository(Question::class)->find($topNok['top2']['question']);
        }
        if (isset($topNok['top3']['question'])) {
            $topNok['top3']['question'] = $this->em->getRepository(Question::class)->find($topNok['top3']['question']);
        }
        foreach ($topNok['top1']['byArea'] as $areaId => $areaValue) {
            $topNok['top1']['byArea'][$areaId] = [
                'area' => $this->em->getRepository(AreaEntity::class)->find($areaId),
                'value' => $areaValue
            ];
        }
        foreach ($topNok['top2']['byArea'] as $areaId => $areaValue) {
            $topNok['top2']['byArea'][$areaId] = [
                'area' => $this->em->getRepository(AreaEntity::class)->find($areaId),
                'value' => $areaValue
            ];
        }
        foreach ($topNok['top3']['byArea'] as $areaId => $areaValue) {
            $topNok['top3']['byArea'][$areaId] = [
                'area' => $this->em->getRepository(AreaEntity::class)->find($areaId),
                'value' => $areaValue
            ];
        }
        if (isset($topCorr['top1']['question'])) {
            $topCorr['top1']['question'] = $this->em->getRepository(Question::class)->find($topCorr['top1']['question']);
        }
        if ($topCorr['top2']['question']) {
            $topCorr['top2']['question'] = $this->em->getRepository(Question::class)->find($topCorr['top2']['question']);
        }
        if (isset($topCorr['top3']['question'])) {
            $topCorr['top3']['question'] = $this->em->getRepository(Question::class)->find($topCorr['top3']['question']);
        }
        
        return [
            AnswerTypes::ANSWER_NOK => $topNok,
            AnswerTypes::ANSWER_CORR => $topCorr
        ];
    }
}