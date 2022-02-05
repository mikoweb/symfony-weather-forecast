<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 */

namespace App\Weather\Reducer;

interface ReducerMapInterface
{
    public function getReducerClass(string $context): string;
}
