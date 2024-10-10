<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Area;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AreaRepository extends ServiceEntityRepository implements AreaRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Area::class);
    }
    
    public function findByAllChild(?string $nothing = null): array
    {
        $qb = $this->createQueryBuilder('a')
            ->select('DISTINCT a.parent')
            ->andWhere('a.parent IS NOT NULL');
        
            
            
        return $qb->getQuery()->getResult();
    }
    
}
