<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 */

namespace App\Weather\Reducer;

interface NumericReducerInterface extends ReducerInterface
{
    public function reduce(array $values): float;
}
