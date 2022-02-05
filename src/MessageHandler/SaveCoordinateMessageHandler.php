<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 */

namespace App\MessageHandler;

use App\Entity\Coordinate;
use App\Message\SaveCoordinateMessage;
use App\Repository\CoordinateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class SaveCoordinateMessageHandler implements MessageHandlerInterface
{
    private ValidatorInterface $validator;
    private EntityManagerInterface $entityManager;
    private CoordinateRepository $repository;

    public function __construct(
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager,
        CoordinateRepository $repository
    )
    {
        $this->validator = $validator;
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    public function __invoke(SaveCoordinateMessage $message): void
    {
        if (!is_null($this->repository->findOneBy(['addressQuery' => $message->addressQuery]))) {
            return;
        }

        $coordinate = new Coordinate(addressQuery: $message->addressQuery, lat: $message->lat, lng: $message->lng);
        $violations = $this->validator->validate($coordinate);

        if (0 !== count($violations)) {
            throw new ValidationFailedException($coordinate, $violations);
        }

        $this->entityManager->persist($coordinate);
        $this->entityManager->flush();
    }
}
