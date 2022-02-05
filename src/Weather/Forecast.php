<?php

namespace App\Weather;

class Forecast implements ForecastInterface
{
    private CoordInterface $coord;
    private float $temperature;
    private int $pressure;
    private int $humidity;
    private int $cloudiness;
    private WindInterface $wind;

    public function __construct(
        CoordInterface $coord,
        float $temperature,
        int $pressure,
        int $humidity,
        int $cloudiness,
        WindInterface $wind
    )
    {
        $this->coord = $coord;
        $this->temperature = $temperature;
        $this->pressure = $pressure;
        $this->humidity = $humidity;
        $this->cloudiness = $cloudiness;
        $this->wind = $wind;
    }

    public function getCoord(): CoordInterface
    {
        return $this->coord;
    }

    public function getTemperature(): float
    {
        return $this->temperature;
    }

    public function getPressure(): int
    {
        return $this->pressure;
    }

    public function getHumidity(): int
    {
        return $this->humidity;
    }

    public function getCloudiness(): int
    {
        return $this->cloudiness;
    }

    public function getWind(): WindInterface
    {
        return $this->wind;
    }
}
