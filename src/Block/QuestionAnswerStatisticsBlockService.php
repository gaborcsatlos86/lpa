<?php

declare(strict_types=1);

namespace App\Block;

use App\Enums\{UserLevel, Area};
use App\Entity\QuestionAnswer;
use Sonata\AdminBundle\Admin\Pool;
use Symfony\Component\HttpFoundation\Response;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\QuestionAnswerRepositoryInterface;
use Twig\Environment;
use \DateTimeImmutable;

class QuestionAnswerStatisticsBlockService extends AbstractBlockService
{
    public function __construct(
        Environment $twig,
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
        
        $todayItems = $this->questionAnswerRepository->findByDate($today);
        $yesterdayItems = $this->questionAnswerRepository->findByDate($yesterday);
        $chart = $this->calculateChart($yesterday, $yesterdayItems);
        $chart = array_merge($chart, $this->calculateChart($today, $todayItems));

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
    
    protected function calculateChart(DateTimeImmutable $date, array $items): array
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
                    if ($questionAnswer->getArea() == Area::AREA_PRODUCTION) {$chartData[$dateString . '-' . UserLevel::LEVEL_1 . '-' . Area::AREA_PRODUCTION]++;}
                    if ($questionAnswer->getArea() == Area::AREA_WAREHOUSE) {$chartData[$dateString . '-' . UserLevel::LEVEL_1 . '-' . Area::AREA_WAREHOUSE]++;}
                    if ($questionAnswer->getArea() == Area::AREA_MAINTENANCE) {$chartData[$dateString . '-' . UserLevel::LEVEL_1 . '-' . Area::AREA_MAINTENANCE]++;}
                break;
                case UserLevel::LEVEL_2:
                    if ($questionAnswer->getArea() == Area::AREA_PRODUCTION) {$chartData[$dateString . '-' . UserLevel::LEVEL_2 . '-' . Area::AREA_PRODUCTION]++;}
                    if ($questionAnswer->getArea() == Area::AREA_WAREHOUSE) {$chartData[$dateString . '-' . UserLevel::LEVEL_2 . '-' . Area::AREA_WAREHOUSE]++;}
                    if ($questionAnswer->getArea() == Area::AREA_MAINTENANCE) {$chartData[$dateString . '-' . UserLevel::LEVEL_2 . '-' . Area::AREA_MAINTENANCE]++;}
                break;
                case UserLevel::LEVEL_3:
                    if ($questionAnswer->getArea() == Area::AREA_PRODUCTION) {$chartData[$dateString . '-' . UserLevel::LEVEL_3 . '-' . Area::AREA_PRODUCTION]++;}
                    if ($questionAnswer->getArea() == Area::AREA_WAREHOUSE) {$chartData[$dateString . '-' . UserLevel::LEVEL_3 . '-' . Area::AREA_WAREHOUSE]++;}
                    if ($questionAnswer->getArea() == Area::AREA_MAINTENANCE) {$chartData[$dateString . '-' . UserLevel::LEVEL_3 . '-' . Area::AREA_MAINTENANCE]++;}
            }
        }
        
        return $chartData;
    }
}