<?php

namespace App\Chart;

#[\AllowDynamicProperties]
class ChartDataset
{
    public array $data = [];
    public array $backgroundColor = [];
    public int $borderRadius = 4;
    public int $spacing = 3;

    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function setBackgroundColor(array $colors): static
    {
        $this->backgroundColor = $colors;

        return $this;
    }

    public function withBarThickness(int $thickness = 20): static
    {
        $this->barThickness = $thickness;

        return $this;
    }

    public function toArray(): array
    {
        return (array) $this;
    }
}
