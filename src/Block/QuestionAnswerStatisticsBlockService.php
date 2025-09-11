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
        
        $areas = $this->initAreas();
        
        return $this->renderResponse($blockContext->getTemplate(), [
            'block'     => $blockContext->getBlock(),
            'settings'  => $settings,
            'admin'     => $admin,
            'areas'     => $areas,
        ], $response);
    }
    
    public function configureSettings(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'icon' => 'fas fa-chart-line',
            'text' => 'Statistics',
            'translation_domain' => null,
            'code' => false,
            'color' => 'grey',
            'filters' => [],
            'limit' => 1000,
            'template' => 'admin/block/block_stats.html.twig',
        ]);
    }
    
    protected function initAreas(): array
    {
        $areas = [];
        
        $prods = $this->em->getRepository(AreaEntity::class)->findBy(['type' => Area::AREA_PRODUCTION]);
        foreach ($prods as $item) {
            $areas[] = [
                'id' => $item->getId(),
                'name' => $item->getName()
            ];
        }
        
        $warehouses = $this->em->getRepository(AreaEntity::class)->findBy(['type' => Area::AREA_WAREHOUSE]);
        foreach ($warehouses as $item) {
            $areas[] = [
                'id' => $item->getId(),
                'name' => $item->getName()
            ];
        }
        
        $maintens = $this->em->getRepository(AreaEntity::class)->findBy(['type' => Area::AREA_MAINTENANCE]);
        foreach ($maintens as $item) {
            $areas[] = [
                'id' => $item->getId(),
                'name' => $item->getName()
            ];
        }
        
        return $areas;
    }
}