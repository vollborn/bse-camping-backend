<?php

namespace App\Classes;

use DateTime;
use Exception;

class Date
{
    /**
     * @throws Exception
     */
    public static function diffInDays(string $startAt, string $endAt): int
    {
        return (new DateTime($endAt))
            ->diff(new DateTime($startAt))
            ->format("%a");
    }

    /**
     * @throws Exception
     */
    public static function diffInYears(string $startAt, string $endAt): int
    {
        return (new DateTime($endAt))
            ->diff(new DateTime($startAt))
            ->format("%y");
    }
}