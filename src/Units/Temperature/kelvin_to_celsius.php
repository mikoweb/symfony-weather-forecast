<?php

namespace App\Units\Temperature;

if (!function_exists(kelvin_to_celsius::class)) {
    function kelvin_to_celsius(float $value): float
    {
        return $value - 273.15;
    }
}
