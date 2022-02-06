<?php

namespace App\Message;

use App\Weather\ForecastInterface;

final class SaveForecastMessage
{
    public readonly ForecastInterface $forecast;
    public readonly string $addressQuery;

    public function __construct(ForecastInterface $forecast, string $addressQuery)
    {
        $this->forecast = $forecast;
        $this->addressQuery = $addressQuery;
    }
}
