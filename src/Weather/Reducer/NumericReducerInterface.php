<?php

namespace App\Weather\Reducer;

interface NumericReducerInterface extends ReducerInterface
{
    public function reduce(array $values): float;
}
