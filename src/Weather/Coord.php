<?php

namespace App\Weather;

class Coord implements CoordInterface
{
    public float $lon;
    public float $lat;

    public function __construct(float $lon, float $lat)
    {
        $this->lon = $lon;
        $this->lat = $lat;
    }

    public function getLon(): float
    {
        return $this->lon;
    }

    public function getLat(): float
    {
        return $this->lat;
    }
}
