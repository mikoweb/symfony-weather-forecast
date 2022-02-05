<?php

namespace App\Weather;

interface CoordInterface
{
    public function getLon(): float;
    public function getLat(): float;
}
