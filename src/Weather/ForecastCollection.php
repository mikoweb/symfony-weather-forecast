<?php

namespace App\Weather;

use Doctrine\Common\Collections\ArrayCollection;
use Iterator;
use function Symfony\Component\String\u;
use UnexpectedValueException;

class ForecastCollection implements Iterator
{
    use CollectionIteratorTrait;

    private ArrayCollection $collection;

    /**
     * @param ForecastInterface[] $forecasts
     */
    public function __construct(array $forecasts = [])
    {
        $this->rewind();
        $this->collection = new ArrayCollection();

        foreach ($forecasts as $forecast) {
            $this->add($forecast);
        }
    }

    public function add(ForecastInterface $forecast): self
    {
        $this->collection->add($forecast);

        return $this;
    }

    public function getColumn(string $colName, ?string $inside = null): array
    {
        $column = [];

        foreach ($this as $forecast) {
            $context = $forecast;

            if (!empty($inside)) {
                $method = 'get' . u($inside)->camel()->title();

                if (!method_exists($context, $method)) {
                    throw new UnexpectedValueException("Column $colName not found. No $method method.");
                }

                $context = $context->{$method}();
            }

            $method = 'get' . u($colName)->camel()->title();

            if (!method_exists($context, $method)) {
                throw new UnexpectedValueException("Column $colName not found. No $method method.");
            }

            $column[] = $context->{$method}();
        }

        return $column;
    }
}
