<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\{AnswerSummary, Area};
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Enums\UserLevel;
use \DateTimeImmutable;

class AnswerSummaryRepository extends ServiceEntityRepository implements AnswerSummaryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnswerSummary::class);
    }
    
    public function getItemsByAreaFromDate(Area $area, \DateTimeImmutable $fromDate): array
    {
        $qb = $this->createQueryBuilder('anssum')
            ->andWhere('anssum.area = :area')
            ->setParameter('area', $area)
            ->andWhere('anssum.periodStart >= :fromDate')
            ->setParameter('fromDate', $fromDate)
            ->addOrderBy('anssum.periodStart', 'ASC')
            ->addOrderBy('anssum.level')
        ;
        return $qb->getQuery()->getResult();
    }
}