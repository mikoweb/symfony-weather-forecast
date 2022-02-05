<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 */

namespace App\Event\Map;

use App\Map\Coordinate;
use Symfony\Contracts\EventDispatcher\Event;

final class FoundCoordinateEvent extends Event
{
    public readonly string $queryAddress;
    public readonly Coordinate $coordinate;

    public function __construct(string $queryAddress, Coordinate $coordinate)
    {
        $this->queryAddress = $queryAddress;
        $this->coordinate = $coordinate;
    }
}
