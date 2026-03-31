<?php

declare(strict_types=1);

namespace App\Service;

interface MonthlySummLevelOneServiceInterface
{
    public function generate(string $month, string $name, int $expectedLpaNum): bool;
}