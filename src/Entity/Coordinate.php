<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 */

namespace App\Entity;

use App\Entity\Interfaces\TimestampableInterface;
use App\Entity\Traits\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CoordinateRepository")
 * @ORM\Table(name="coordinates")
 *
 * @UniqueEntity(fields={"id"}, errorPath="id")
 * @UniqueEntity(fields={"addressQuery"}, errorPath="addressQuery")
 */
class Coordinate implements TimestampableInterface
{
    use TimestampableTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", name="id", unique=true)
     */
    private string $id;

    /**
     * @ORM\Column(name="address_query", type="string", length=255, nullable=false, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     */
    private string $addressQuery;

    /**
     * @ORM\Column(name="lat", type="decimal", precision=9, scale=6, nullable=false)
     * @Assert\NotBlank()
     */
    private float $lat;

    /**
     * @ORM\Column(name="lng", type="decimal", precision=9, scale=6, nullable=false)
     * @Assert\NotBlank()
     */
    private float $lng;

    public function __construct(string $addressQuery, float $lat, float $lng)
    {
        $this->id = Uuid::v4();
        $this->addressQuery = $addressQuery;
        $this->lat = $lat;
        $this->lng = $lng;
    }

    public function getId(): UuidV4|string
    {
        return $this->id;
    }

    public function getAddressQuery(): string
    {
        return $this->addressQuery;
    }

    public function setAddressQuery(string $addressQuery): self
    {
        $this->addressQuery = $addressQuery;

        return $this;
    }

    public function getLat(): float
    {
        return $this->lat;
    }

    public function setLat(float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): float
    {
        return $this->lng;
    }

    public function setLng(float $lng): self
    {
        $this->lng = $lng;

        return $this;
    }
}
