<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 */

namespace App\Weather;

interface CoordInterface
{
    public function getLon(): float;
    public function getLat(): float;
}
