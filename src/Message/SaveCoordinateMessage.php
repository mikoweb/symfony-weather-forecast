<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 */

namespace App\Message;

final class SaveCoordinateMessage
{
    public readonly string $addressQuery;
    public readonly float $lat;
    public readonly float $lng;

    public function __construct(string $addressQuery, float $lat, float $lng)
    {
        $this->addressQuery = $addressQuery;
        $this->lat = $lat;
        $this->lng = $lng;
    }
}
