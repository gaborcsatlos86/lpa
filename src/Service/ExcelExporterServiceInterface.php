<?php

declare(strict_types=1);

namespace App\Service;

interface ExcelExporterServiceInterface
{
    public function export(array $dataSource, string $fileName): bool;
}