<?php

namespace App\Weather;

interface ForecastInterface
{
    public function getTemperature(): float;
    public function getPressure(): int;
    public function getHumidity(): int;
    public function getCloudiness(): int;
    public function getWind(): WindInterface;
}
