<?php

namespace App\Weather\Reducer;

final class MeanReducer implements NumericReducerInterface
{
    public function reduce(array $values): float
    {
        return array_sum($values) / count($values);
    }
}
