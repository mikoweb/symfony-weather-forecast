<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 */

namespace App\Weather\DataSource\Randomize;

use App\Weather\CoordInterface;
use App\Weather\DataSource\GetForecastQueryInterface;
use App\Weather\DataSource\OpenWeather\GetForecastQuery as BaseGetForecastQuery;
use App\Weather\Forecast;
use App\Weather\ForecastInterface;
use App\Weather\Wind;

final class GetForecastQuery implements GetForecastQueryInterface
{
    private BaseGetForecastQuery $query;

    public function __construct(BaseGetForecastQuery $query)
    {
        $this->query = $query;
    }

    public function get(CoordInterface $coord): ForecastInterface
    {
        $base = $this->query->get($coord);

        return new Forecast(
            coord: clone $coord,
            temperature: $this->rand($base->getTemperature(), 4),
            pressure: $this->rand($base->getPressure(), 300, 0),
            humidity: $this->rand($base->getHumidity(), 20, 0),
            cloudiness: $this->rand($base->getCloudiness(), 20, 0),
            wind: new Wind(
                speed: $this->rand($base->getWind()->getSpeed(), 10, 0),
                deg: $this->rand($base->getWind()->getDeg(), 30),
            )
        );
    }

    private function rand(int $value, int $range, ?int $min = null): int
    {
        return rand($min ?? $value - $range, $value + $range);
    }
}
