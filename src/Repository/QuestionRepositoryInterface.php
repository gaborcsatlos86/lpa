<?php

declare(strict_types=1);

namespace App\Repository;

interface QuestionRepositoryInterface
{
    public function findByDistinctExternal(): array;
}