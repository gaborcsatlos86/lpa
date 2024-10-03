<?php

declare(strict_types=1);

namespace App\Enums;

class Area
{
    public const AREA_PRODUCTION = 'production';
    public const AREA_WAREHOUSE = 'warehouse';
    public const AREA_MAINTENANCE = 'maintenance';
    
    public static function getItems(): array
    {
        return [
            'production' => self::AREA_PRODUCTION,
            'warehouse' => self::AREA_WAREHOUSE,
            'maintenance' => self::AREA_MAINTENANCE,
        ];
    }
    
}