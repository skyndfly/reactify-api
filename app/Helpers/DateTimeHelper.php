<?php

namespace App\Helpers;

use Carbon\Carbon;
use DateTime;

class DateTimeHelper
{
    /**
     * @throws \Exception
     */
    public static function hourCalculate(string $startTime, string $endTime): float|int
    {
        $startTime = new DateTime($startTime);
        $endTime = new DateTime($endTime);
        $interval = $startTime->diff($endTime);
        return ($interval->days * 24) + $interval->h + ($interval->i / 60); // Расчет общего времени в часах
    }

    /**
     * возвращает разницу в минутах
     */
    public static function compareDateTimeInMinutes(string $startTime, string $endTime): float
    {
        $startTime = Carbon::parse($startTime);
        $endTime = Carbon::parse($endTime);

        return $startTime->diffInMinutes($endTime);
    }

}
