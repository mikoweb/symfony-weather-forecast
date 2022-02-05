<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 */

namespace App\Weather\DataSource;

use App\Weather\CollectionIteratorTrait;
use App\Weather\CoordInterface;
use App\Weather\ForecastCollection;
use Doctrine\Common\Collections\ArrayCollection;
use Iterator;

class GetForecastQueryCollection implements Iterator
{
    use CollectionIteratorTrait;

    private ArrayCollection $collection;

    /**
     * @param GetForecastQueryInterface[] $queries
     */
    public function __construct(array $queries)
    {
        $this->rewind();
        $this->collection = new ArrayCollection();

        foreach ($queries as $query) {
            $this->add($query);
        }
    }

    public function add(GetForecastQueryInterface $query): self
    {
        $this->collection->add($query);

        return $this;
    }

    public function getResult(CoordInterface $coord): ForecastCollection
    {
        $result = new ForecastCollection();

        foreach ($this as $query) {
            $result->add($query->get(clone $coord));
        }

        return $result;
    }
}
