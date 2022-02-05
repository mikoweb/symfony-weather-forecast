<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 */

namespace App\Query;

use App\Map\Coordinate;
use App\Map\FromEntityCoordinateConverter;
use App\Map\Query\GetCoordinatesFromAddressQuery;
use App\Repository\CoordinateRepository;

final class FindCoordinatesQuery
{
    private GetCoordinatesFromAddressQuery $query;
    private CoordinateRepository $repository;

    public function __construct(GetCoordinatesFromAddressQuery $query, CoordinateRepository $repository)
    {
        $this->query = $query;
        $this->repository = $repository;
    }

    public function find(string $address): Coordinate
    {
        $entity = $this->repository->findOneBy(['addressQuery' => $address]);

        if (is_null($entity)) {
            return $this->query->get($address);
        }

        return FromEntityCoordinateConverter::convert($entity);
    }
}
