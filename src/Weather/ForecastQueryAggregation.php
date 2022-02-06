<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 */

namespace App\Weather;

use App\Event\Weather\DownloadForecastEvent;
use App\Weather\DataSource\GetForecastQueryCollection;
use App\Weather\Reducer\ForecastReducerMap;
use App\Weather\Reducer\ReducerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ForecastQueryAggregation
{
    private GetForecastQueryCollection $collection;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(GetForecastQueryCollection $collection, EventDispatcherInterface $eventDispatcher)
    {
        $this->collection = $collection;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function aggregate(CoordInterface $coord, ?string $queryAddress = null): ForecastInterface
    {
        $forecasts = $this->collection->getResult($coord);
        $forecast = new Forecast(
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

        if (!is_null($queryAddress)) {
            $this->eventDispatcher->dispatch(new DownloadForecastEvent($queryAddress, $forecast));
        }

        return $forecast;
    }

    private function getReducer(string $context): ReducerInterface
    {
        $reducerClass = (new ForecastReducerMap())->getReducerClass($context);

        return new $reducerClass;
    }
}
