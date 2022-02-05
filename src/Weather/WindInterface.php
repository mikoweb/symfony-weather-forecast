<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 */

namespace App\Weather;

interface WindInterface
{
    public function getSpeed(): float;
    public function getDeg(): int;
}
