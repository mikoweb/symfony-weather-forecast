<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 */

namespace App\Event\Weather;

use App\Weather\ForecastInterface;
use Symfony\Contracts\EventDispatcher\Event;

final class DownloadForecastEvent extends Event
{
    public readonly string $queryAddress;
    public readonly ForecastInterface $forecast;

    public function __construct(string $queryAddress, ForecastInterface $forecast)
    {
        $this->queryAddress = $queryAddress;
        $this->forecast = $forecast;
    }
}
