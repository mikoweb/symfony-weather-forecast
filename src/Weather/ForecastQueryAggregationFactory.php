<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 */

namespace App\Weather;

use App\Weather\DataSource\GetForecastQueryCollection;
use App\Weather\DataSource\OpenWeather\GetForecastQuery as OpenWeatherQuery;
use App\Weather\DataSource\Randomize\GetForecastQuery as RandomizeQuery;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class ForecastQueryAggregationFactory
{
    private EventDispatcherInterface $eventDispatcher;
    private OpenWeatherQuery $query1;
    private RandomizeQuery $query2;

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        OpenWeatherQuery $query1,
        RandomizeQuery $query2
    )
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->query1 = $query1;
        $this->query2 = $query2;
    }

    public function create(): ForecastQueryAggregation
    {
        return new ForecastQueryAggregation(new GetForecastQueryCollection([
            $this->query1,
            $this->query2
        ]), $this->eventDispatcher);
    }
}
