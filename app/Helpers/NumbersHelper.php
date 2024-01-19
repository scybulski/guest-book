<?php

namespace App\Helpers;

class NumbersHelper
{
    public static function clamp(int|float $number, int|float $min, int|float $max): int|float
    {
        return min(max($number, $min), $max);
    }
}
