<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class QuestionRepository extends ServiceEntityRepository implements QuestionRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }
    
    public function findByDistinctExternal(): array
    {
        $qb = $this->createQueryBuilder('q')
            ->select('DISTINCT q.externalId')
            ->andWhere('q.active = :isActive')
            ->setParameter('isActive', true)
        ;    
            
        return $qb->getQuery()->getResult();
    }
    
}
