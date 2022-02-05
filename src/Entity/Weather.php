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
 * @ORM\Entity(repositoryClass="App\Repository\WeatherRepository")
 * @ORM\Table(name="weathers")
 *
 * @UniqueEntity(fields={"id"}, errorPath="id")
 * @UniqueEntity(fields={"addressQuery"}, errorPath="addressQuery")
 */
class Weather implements TimestampableInterface
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

    /**
     * @ORM\Column(name="temperature", type="decimal", precision=6, scale=3, nullable=false)
     * @Assert\NotBlank()
     */
    private float $temperature;

    /**
     * @ORM\Column(name="pressure", type="integer", length=5, nullable=false)
     * @Assert\NotBlank()
     */
    private int $pressure;

    /**
     * @ORM\Column(name="humidity", type="integer", length=3, nullable=false)
     * @Assert\NotBlank()
     */
    private int $humidity;

    /**
     * @ORM\Column(name="cloudiness", type="integer", length=3, nullable=false)
     * @Assert\NotBlank()
     */
    private int $cloudiness;

    /**
     * @ORM\Column(name="wind_speed", type="decimal", precision=6, scale=3, nullable=false)
     * @Assert\NotBlank()
     */
    private float $windSpeed;

    /**
     * @ORM\Column(name="wind_deg", type="integer", length=3, nullable=false)
     * @Assert\NotBlank()
     */
    private int $windDeg;

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

    public function getTemperature(): float
    {
        return $this->temperature;
    }

    public function setTemperature(float $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getPressure(): int
    {
        return $this->pressure;
    }

    public function setPressure(int $pressure): self
    {
        $this->pressure = $pressure;

        return $this;
    }

    public function getHumidity(): int
    {
        return $this->humidity;
    }

    public function setHumidity(int $humidity): self
    {
        $this->humidity = $humidity;

        return $this;
    }

    public function getCloudiness(): int
    {
        return $this->cloudiness;
    }

    public function setCloudiness(int $cloudiness): self
    {
        $this->cloudiness = $cloudiness;

        return $this;
    }

    public function getWindSpeed(): float
    {
        return $this->windSpeed;
    }

    public function setWindSpeed(float $windSpeed): self
    {
        $this->windSpeed = $windSpeed;

        return $this;
    }

    public function getWindDeg(): int
    {
        return $this->windDeg;
    }

    public function setWindDeg(int $windDeg): self
    {
        $this->windDeg = $windDeg;

        return $this;
    }
}
