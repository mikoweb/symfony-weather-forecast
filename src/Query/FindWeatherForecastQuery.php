<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 */

namespace App\Query;

use App\Weather\Coord;
use App\Weather\ForecastInterface;
use App\Weather\ForecastQueryAggregationFactory;

final class FindWeatherForecastQuery
{
    private ForecastQueryAggregationFactory $queryAggregationFactory;
    private FindCoordinatesQuery $findCoordinatesQuery;

    public function __construct(
        ForecastQueryAggregationFactory $queryAggregationFactory,
        FindCoordinatesQuery $findCoordinatesQuery
    )
    {
        $this->queryAggregationFactory = $queryAggregationFactory;
        $this->findCoordinatesQuery = $findCoordinatesQuery;
    }

    public function find(string $country, string $city): ForecastInterface
    {
        $coordindates = $this->findCoordinatesQuery->find("$country $city");

        // TODO save results to db and refresh from time to time

        return $this->queryAggregationFactory->create()->aggregate(
            new Coord(lon: $coordindates->lng, lat: $coordindates->lat)
        );
    }
}
