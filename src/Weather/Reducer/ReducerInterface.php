<?php

namespace App\Weather\Reducer;

interface ReducerInterface
{
    public function reduce(array $values): mixed;
}
