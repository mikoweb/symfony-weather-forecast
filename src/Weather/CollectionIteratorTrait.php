<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 */

namespace App\Weather;

trait CollectionIteratorTrait
{
    private int $position = 0;

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function current(): mixed
    {
        return $this->collection->get($this->position);
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function valid(): bool
    {
        return $this->collection->containsKey($this->position);
    }
}
