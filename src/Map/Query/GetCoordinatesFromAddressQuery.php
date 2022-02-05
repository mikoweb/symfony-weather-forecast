<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 */

namespace App\Map\Query;

use App\Map\Coordinates;
use App\Map\GoogleMapsClient;
use App\Map\Query\Exceptions\NotFoundCoordinatesException;
use Symfony\Component\PropertyAccess\PropertyAccess;

final class GetCoordinatesFromAddressQuery
{
    private GoogleMapsClient $client;

    public function __construct(GoogleMapsClient $client)
    {
        $this->client = $client;
    }

    public function get(string $address): Coordinates
    {
        $response = $this->client->request('GET', '/maps/api/place/findplacefromtext/json?' . http_build_query([
            'input' => $address,
            'inputtype' => 'textquery',
            'fields' => 'formatted_address,name,rating,opening_hours,geometry'
        ]));

        $data = $response->toArray();
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        $location = $propertyAccessor->getValue($data, '[candidates][0][geometry][location]');

        if (empty($location)) {
            throw new NotFoundCoordinatesException("Not found coordinates for $address");
        }

        return new Coordinates(lat: $location['lat'], lng: $location['lng']);
    }
}
