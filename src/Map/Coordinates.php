<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 */

namespace App\Map;

final class Coordinates
{
    public readonly float $lat;
    public readonly float $lng;

    public function __construct(float $lat, float $lng)
    {
        $this->lat = $lat;
        $this->lng = $lng;
    }
}
