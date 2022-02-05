<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 */

namespace App\Weather;

use App\Weather\DataSource\GetForecastQueryCollection;
use App\Weather\Reducer\ForecastReducerMap;
use App\Weather\Reducer\ReducerInterface;

class ForecastQueryAggregation
{
    private GetForecastQueryCollection $collection;

    public function __construct(GetForecastQueryCollection $collection)
    {
        $this->collection = $collection;
    }

    public function aggregate(CoordInterface $coord): ForecastInterface
    {
        $forecasts = $this->collection->getResult($coord);

        return new Forecast(
            coord: clone $coord,
            temperature: $this->getReducer('temperature')->reduce($forecasts->getColumn('temperature')),
            pressure: $this->getReducer('pressure')->reduce($forecasts->getColumn('pressure')),
            humidity: $this->getReducer('humidity')->reduce($forecasts->getColumn('humidity')),
            cloudiness: $this->getReducer('cloudiness')->reduce($forecasts->getColumn('cloudiness')),
            wind: new Wind(
                speed: $this->getReducer('wind_speed')->reduce($forecasts->getColumn('speed', 'wind')),
                deg: $this->getReducer('wind_deg')->reduce($forecasts->getColumn('deg', 'wind'))
            )
        );
    }

    private function getReducer(string $context): ReducerInterface
    {
        $reducerClass = (new ForecastReducerMap())->getReducerClass($context);

        return new $reducerClass;
    }
}
