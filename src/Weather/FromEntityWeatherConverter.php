<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 */

namespace App\Weather;

use App\Entity\Weather;

final class FromEntityWeatherConverter
{
    public static function convert(Weather $weather): ForecastInterface
    {
        return new Forecast(
            coord: new Coord(lon: $weather->getLng(), lat: $weather->getLat()),
            temperature: $weather->getTemperature(),
            pressure: $weather->getPressure(),
            humidity: $weather->getHumidity(),
            cloudiness: $weather->getCloudiness(),
            wind: new Wind(
                speed: $weather->getWindSpeed(),
                deg: $weather->getWindDeg()
            )
        );
    }
}
