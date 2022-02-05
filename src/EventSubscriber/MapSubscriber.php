<?php
/*
 * Copyright (c) Rafał Mikołajun 2021.
 */

namespace App\EventSubscriber;

use App\Event\Map\FoundCoordinateEvent;
use App\Message\SaveCoordinateMessage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class MapSubscriber implements EventSubscriberInterface
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            FoundCoordinateEvent::class => 'onFoundCoordinate',
        ];
    }

    public function onFoundCoordinate(FoundCoordinateEvent $event): void
    {
        $this->bus->dispatch(
            new SaveCoordinateMessage($event->queryAddress, $event->coordinate->lat, $event->coordinate->lng)
        );
    }
}
