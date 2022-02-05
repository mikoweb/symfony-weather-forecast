<?php

namespace App\Weather;

class Wind implements WindInterface
{
    private float $speed;
    private int $deg;

    public function __construct(float $speed, int $deg)
    {
        $this->speed = $speed;
        $this->deg = $deg;
    }

    public function getSpeed(): float
    {
        return $this->speed;
    }

    public function getDeg(): int
    {
        return $this->deg;
    }
}
