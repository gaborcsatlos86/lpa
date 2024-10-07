<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\QuestionAnswer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use \DateTimeImmutable;

class QuestionAnswerRepository extends ServiceEntityRepository implements QuestionAnswerRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestionAnswer::class);
    }
    
    public function findByDate(DateTimeImmutable $date): array
    {
        $qb = $this->createQueryBuilder('qa')
            ->andWhere('qa.createdAt LIKE :date')
            ->setParameter('date', $date->format('Y-m-d').'%');
        
        return $qb->getQuery()->getResult();
    }
}