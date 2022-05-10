<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateTimeHelper
{
    public static function getFirstDayOfWeek()
    {
        return Carbon::parse(date('Y-m-d 00:00:00', strtotime("this week")));
    }

    public static function getLastDayOfWeek()
    {
        return Carbon::parse(date('Y-m-d 00:00:00', strtotime("this week, + 6 days")));
    }
}
