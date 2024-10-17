<?php

declare(strict_types=1);

namespace App\Controller\Portal;


use App\Entity\{User, TableGroup, QuestionAnswer, Area};
use App\Enums\{UserLevel};
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->render('base.html.twig', [
                'last_username' => '',
            ]);
        }
        
        $areas = $this->getAllChildArea($entityManager);
        
        if ($user->getLevel() == UserLevel::LEVEL_1) {
            $tableGroups = $entityManager->getRepository(TableGroup::class)->findBy(['deletedAt' => null]);
            
            return $this->render('base.html.twig', [
                'last_username' => $user->getName(),
                'areas' => $areas,
                'default_area' => $user->getArea(),
                'table_groups' => $tableGroups,
                'is_level_1' => true
            ]);
        }
        
        $tableGroups = null;
        $toNextStep = false;
        
        if ($request->getMethod() == Request::METHOD_POST) {
            $userAnswers = $entityManager->getRepository(QuestionAnswer::class)->createQueryBuilder('qa')
                ->andWhere('qa.area = :area')
                ->andWhere('qa.level = :level')
                ->andWhere('qa.createdAt LIKE :today')
                ->setParameter('area', $request->request->get('area'))
                ->setParameter('level', ($user->getLevel() == UserLevel::LEVEL_2) ? UserLevel::LEVEL_1 : UserLevel::LEVEL_2)
                ->setParameter('today', (new \DateTimeImmutable())->format('Y-m-d').'%')
                ->getQuery()->getResult();
            
            $tableGroups = [];
            foreach ($userAnswers as $answer) {
                if (!isset($tableGroups[$answer->getTableGroup()->getId()])) {
                    $tableGroups[$answer->getTableGroup()->getId()] = $answer->getTableGroup();
                }
            }
            $tableGroups = array_values($tableGroups);
            if (!empty($tableGroups)) {
                $toNextStep = true;
            }
        }
        
        return $this->render('base.html.twig', [
            'last_username' => $user->getName(),
            'areas' => $areas,
            'default_area' => $user->getArea(),
            'table_groups' => $tableGroups,
            'is_level_1' => $toNextStep
        ]);
    }
    
    private function getAllChildArea($entityManager): array
    {
        $parentQb = $entityManager->getRepository(Area::class)->createQueryBuilder('a')
            ->andWhere('a.parent IS NOT NULL');
        
        $parents = $parentQb->getQuery()->getResult();
        $parentIds = [];
        foreach ($parents as $parent) {
            if (!in_array($parent->getParent()->getId(), $parentIds)) {
                $parentIds[] = $parent->getParent()->getId();
            }
        }
        
        $qb = $entityManager->getRepository(Area::class)->createQueryBuilder('a')
            ->andWhere('a.id NOT IN (:ids)')
            ->setParameter('ids', $parentIds)
        ;
        return $qb->getQuery()->getResult();
    }
    
    
}