<?php
namespace App\Services;

use Illuminate\Support\Str;

class AcademyEventService {

    public static function getHours()
    {
        $hours = [];
        for ($i = 1; $i < 24; $i++) {
            $hours[$i] = self::addLeadingZero($i);
        }
        return $hours;
    }

    public static function getMinutes()
    {
        $minutes = [];
        for ($i = 0; $i < 60; $i+=5) {
            $minutes[$i] = self::addLeadingZero($i);
        }
        return $minutes;
    }

    public static function addLeadingZero($value)
    {
        if ($value < 10) {
            $value = 0 . $value;
        }
        return $value;
    }

    public static function removeLeadingZero($value)
    {
        if (Str::startsWith($value, '0')) {
            return substr($value, 1);
        }
        return $value;
    }
}
