<?php

namespace App\Weather\DataSource;

use App\Weather\CoordInterface;
use App\Weather\ForecastInterface;

interface GetForecastQueryInterface
{
    public function get(CoordInterface $coord): ForecastInterface;
}
