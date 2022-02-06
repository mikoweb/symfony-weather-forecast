<?php
/*
 * Copyright (c) Rafał Mikołajun 2021.
 */

namespace App\EventSubscriber;

use App\Event\Weather\DownloadForecastEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class WeatherSubscriber implements EventSubscriberInterface
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            DownloadForecastEvent::class => 'onDownloadForecast',
        ];
    }

    public function onDownloadForecast(DownloadForecastEvent $event): void
    {
        // TODO save forecast to db
    }
}
