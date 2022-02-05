<?php

namespace App\Weather\DataSource\OpenWeather;

use App\Weather\CoordInterface;
use App\Weather\DataSource\GetForecastQueryInterface;
use App\Weather\Forecast;
use App\Weather\ForecastInterface;
use App\Weather\Wind;
use function App\Units\Temperature\kelvin_to_celsius;

final class GetForecastQuery implements GetForecastQueryInterface
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function get(CoordInterface $coord): ForecastInterface
    {
        $response = $this->client->request('GET', '/data/2.5/weather?' . http_build_query([
            'lat' => $coord->getLat(),
            'lon' => $coord->getLon(),
        ]));

        $data = $response->toArray();

        return new Forecast(
            coord: clone $coord,
            temperature: kelvin_to_celsius($data['main']['temp']),
            pressure: $data['main']['pressure'],
            humidity: $data['main']['humidity'],
            cloudiness: $data['clouds']['all'],
            wind: new Wind(
                speed: $data['wind']['speed'],
                deg: $data['wind']['deg']
            )
        );
    }
}
