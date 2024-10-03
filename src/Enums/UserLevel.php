<?php

declare(strict_types=1);

namespace App\Enums;

class UserLevel
{
    public const LEVEL_1 = 'level-1';
    public const LEVEL_2 = 'level-2';
    public const LEVEL_3 = 'level-3';
    
    public static function getItems(): array
    {
        return [
            'Level 1' => self::LEVEL_1,
            'Level 2' => self::LEVEL_2,
            'Level 3' => self::LEVEL_3,
        ];
    }
}