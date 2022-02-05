<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 */

namespace App\Weather;

use App\Weather\DataSource\GetForecastQueryCollection;
use App\Weather\DataSource\OpenWeather\GetForecastQuery as OpenWeatherQuery;
use App\Weather\DataSource\Randomize\GetForecastQuery as RandomizeQuery;

final class ForecastQueryAggregationFactory
{
    private OpenWeatherQuery $query1;
    private RandomizeQuery $query2;

    public function __construct(OpenWeatherQuery $query1, RandomizeQuery $query2)
    {
        $this->query1 = $query1;
        $this->query2 = $query2;
    }

    public function create(): ForecastQueryAggregation
    {
        return new ForecastQueryAggregation(new GetForecastQueryCollection([
            $this->query1,
            $this->query2
        ]));
    }
}
