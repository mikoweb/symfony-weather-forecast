<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 */

namespace App\Weather\Reducer;

final class ForecastReducerMap implements ReducerMapInterface
{
    public function getReducerClass(string $context): string
    {
        return match ($context) {
            default => MeanReducer::class
        };
    }
}
