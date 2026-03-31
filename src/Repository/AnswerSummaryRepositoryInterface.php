<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Area;

interface AnswerSummaryRepositoryInterface
{
    public function getItemsByAreaFromDate(Area $area, \DateTimeImmutable $fromDate): array;
    public function getItemsByDate(string $month): array;
}