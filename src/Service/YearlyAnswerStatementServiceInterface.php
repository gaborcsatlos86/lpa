<?php

declare(strict_types=1);

namespace App\Service;


interface YearlyAnswerStatementServiceInterface
{
    public function generate(int $year, string $answer, string $name): bool;
}