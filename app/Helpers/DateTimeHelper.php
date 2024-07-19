<?php

namespace App\Helpers;

use DateTime;

class DateTimeHelper
{
    /**
     * @throws \Exception
     */
    public static function HoursCalculate(string $startTime, string $endTime): float|int
    {
        $startTime = new DateTime($startTime);
        $endTime = new DateTime($endTime);
        $interval = $startTime->diff($endTime);
        return ($interval->days * 24) + $interval->h + ($interval->i / 60); // Расчет общего времени в часах
    }

}
