<?php

namespace App\Chart;

use ReflectionClass;

class ChartData
{
    public array $labels = [];
    #[toArray]
    public array $datasets = [];
    public array $extra = [];

    public function setLabels(array $labels): static
    {
        $this->labels = $labels;

        return $this;
    }

    public function addDataset(ChartDataset $dataset): static
    {
        $this->datasets[] = $dataset;

        return $this;
    }

    public function setExtra(array $extra): static
    {
        $this->extra = $extra;

        return $this;
    }

    public function toArray(): array
    {
        $ref = new ReflectionClass($this);
        foreach ($ref->getProperties() as $property) {
            $attributes = $property->getAttributes(ToArray::class);

            if (!empty($attributes)) {
                foreach ($property->getValue($this) as $value) {
                    $property->setValue($this, [$value->toArray()]);
                }
            }
        }

        return (array) $this;
    }
}
