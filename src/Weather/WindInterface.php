<?php

namespace App\Weather;

interface WindInterface
{
    public function getSpeed(): float;
    public function getDeg(): int;
}
