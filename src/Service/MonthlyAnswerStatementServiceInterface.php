<?php

declare(strict_types=1);

namespace App\Service;


interface MonthlyAnswerStatementServiceInterface
{
    public function generate(string $month, string $answer, string $name): bool;
}