<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 */

namespace App\Query;

use App\Repository\WeatherRepository;
use App\Weather\Coord;
use App\Weather\ForecastInterface;
use App\Weather\ForecastQueryAggregationFactory;
use App\Weather\FromEntityWeatherConverter;
use DateTime;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final class FindWeatherForecastQuery
{
    private ForecastQueryAggregationFactory $queryAggregationFactory;
    private FindCoordinatesQuery $findCoordinatesQuery;
    private WeatherRepository $repository;
    private ParameterBagInterface $parameterBag;

    public function __construct(
        ForecastQueryAggregationFactory $queryAggregationFactory,
        FindCoordinatesQuery $findCoordinatesQuery,
        WeatherRepository $repository,
        ParameterBagInterface $parameterBag
    )
    {
        $this->queryAggregationFactory = $queryAggregationFactory;
        $this->findCoordinatesQuery = $findCoordinatesQuery;
        $this->repository = $repository;
        $this->parameterBag = $parameterBag;
    }

    public function find(string $country, string $city): ForecastInterface
    {
        $cacheTime = (int) $this->parameterBag->get('app_weather_forecast_cache_time');
        $addressQuery = "$country $city";
        $entity = $this->repository->findOneBy(['addressQuery' => $addressQuery]);

        if (is_null($entity) || new DateTime() < (clone $entity->getCreatedAt())->modify("$cacheTime seconds")) {
            return $this->findFromApi($addressQuery);
        }

        return FromEntityWeatherConverter::convert($entity);
    }

    private function findFromApi(string $addressQuery): ForecastInterface
    {
        $coordinates = $this->findCoordinatesQuery->find($addressQuery);

        return $this->queryAggregationFactory->create()->aggregate(
            new Coord(lon: $coordinates->lng, lat: $coordinates->lat),
            $addressQuery
        );
    }
}
