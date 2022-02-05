<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 */

namespace App\Map\Query;

use App\Event\Map\FoundCoordinateEvent;
use App\Map\Coordinate;
use App\Map\GoogleMapsClient;
use App\Map\Query\Exceptions\NotFoundCoordinatesException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

final class GetCoordinatesFromAddressQuery
{
    private GoogleMapsClient $client;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(GoogleMapsClient $client, EventDispatcherInterface $eventDispatcher)
    {
        $this->client = $client;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function get(string $address): Coordinate
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

        $coordinate = new Coordinate(lat: $location['lat'], lng: $location['lng']);
        $this->eventDispatcher->dispatch(new FoundCoordinateEvent($address, $coordinate));

        return $coordinate;
    }
}
