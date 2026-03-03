<?php

declare(strict_types=1);

namespace App\Service\Admin;

use App\Entity\Area;

interface CalendarServiceInterface
{
    public function calculateCalendarData(Area $area, \DateTimeImmutable $fromDate): array;
    public function getDays(\DateTimeImmutable $fromDate): array;
}