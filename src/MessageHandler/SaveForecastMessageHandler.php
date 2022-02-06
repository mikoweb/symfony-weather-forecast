<?php

namespace App\MessageHandler;

use App\Entity\Weather;
use App\Message\SaveForecastMessage;
use App\Repository\WeatherRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class SaveForecastMessageHandler implements MessageHandlerInterface
{
    private ValidatorInterface $validator;
    private EntityManagerInterface $entityManager;
    private WeatherRepository $repository;

    public function __construct(
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager,
        WeatherRepository $repository
    )
    {
        $this->validator = $validator;
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    public function __invoke(SaveForecastMessage $message)
    {
        $entity = $this->repository->findOneBy(['addressQuery' => $message->addressQuery]);
        $forecast = $message->forecast;

        if (is_null($entity)) {
            $entity = new Weather(
                addressQuery: $message->addressQuery,
                lat: $forecast->getCoord()->getLat(),
                lng: $forecast->getCoord()->getLon(),
                temperature: $forecast->getTemperature(),
                pressure: $forecast->getPressure(),
                humidity: $forecast->getHumidity(),
                cloudiness: $forecast->getCloudiness(),
                windSpeed: $forecast->getWind()->getSpeed(),
                windDeg: $forecast->getWind()->getDeg()
            );
        } else {
            $entity
                ->setLat($forecast->getCoord()->getLat())
                ->setLng($forecast->getCoord()->getLon())
                ->setTemperature($forecast->getTemperature())
                ->setPressure($forecast->getPressure())
                ->setHumidity($forecast->getHumidity())
                ->setCloudiness($forecast->getCloudiness())
                ->setWindSpeed($forecast->getWind()->getSpeed())
                ->setWindDeg($forecast->getWind()->getDeg())
            ;
        }

        $violations = $this->validator->validate($entity);

        if (0 !== count($violations)) {
            throw new ValidationFailedException($entity, $violations);
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}
