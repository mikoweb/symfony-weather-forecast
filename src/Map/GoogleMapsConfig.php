<?php

namespace App\Map;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final class GoogleMapsConfig
{
    private string $apiKey;

    public function __construct(ParameterBagInterface $bag)
    {
        $this->apiKey = $bag->get('app_google_maps_api_key');
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getBaseURI(): string
    {
        return 'https://maps.googleapis.com';
    }
}
