<?php

namespace App\Weather\DataSource\OpenWeather;

final class Config
{
    private string $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getBaseURI(): string
    {
        return 'https://api.openweathermap.org';
    }
}
