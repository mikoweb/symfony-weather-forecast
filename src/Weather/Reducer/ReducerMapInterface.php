<?php

namespace App\Weather\Reducer;

interface ReducerMapInterface
{
    public function getReducerClass(string $context): string;
}
