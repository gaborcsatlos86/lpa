<?php

declare(strict_types=1);

namespace App\Enums;

class AnswerTypes {
    
    public const ANSWER_OK = 'OK';
    public const ANSWER_NOK = 'NOK';
    public const ANSWER_NA = 'N/A';
    public const ANSWER_CORR = 'Corr';
    public const ANSWER_NOT_WORKING_DAY = 'Munkaszüneti nap';
    
    public static function getItems(): array
    {
        return [
            self::ANSWER_OK => self::ANSWER_OK,
            self::ANSWER_NOK => self::ANSWER_NOK,
            self::ANSWER_NA => self::ANSWER_NA,
            self::ANSWER_CORR => self::ANSWER_CORR
        ];
    }
    
    public static function getSummaryItems(): array
    {
        return [
            self::ANSWER_OK => self::ANSWER_OK,
            self::ANSWER_NOK => self::ANSWER_NOK,
            self::ANSWER_NOT_WORKING_DAY => self::ANSWER_NOT_WORKING_DAY
        ];
    }
}