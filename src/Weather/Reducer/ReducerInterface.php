<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 */

namespace App\Weather\Reducer;

interface ReducerInterface
{
    public function reduce(array $values): mixed;
}
