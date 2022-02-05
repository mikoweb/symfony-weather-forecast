<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 */

namespace App\Map;

use App\Entity\Coordinate as BaseCoordinate;

final class FromEntityCoordinateConverter
{
    public static function convert(BaseCoordinate $coordinate): Coordinate
    {
        return new Coordinate(lat: $coordinate->getLat(), lng: $coordinate->getLng());
    }
}
