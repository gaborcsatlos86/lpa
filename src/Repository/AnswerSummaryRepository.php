<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\AnswerSummary;
use App\Entity\QuestionAnswer;
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
    
    
}