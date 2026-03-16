<?php

declare(strict_types=1);

namespace App\Repository;

use \DateTimeImmutable;

interface QuestionAnswerRepositoryInterface
{
    public function findByDate(DateTimeImmutable $date): array;
    public function findByDateAndAnswer(string $date, string $answer): array;
}