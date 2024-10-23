<?php

namespace App\Chart;

class ChartOptions
{
    public bool $maintainAspectRatio = false;
    public array $plugins = [];
    public array $layout = [];

    public function withAspectRatio(): static
    {
        $this->maintainAspectRatio = true;

        return $this;
    }

    public function withoutLegend(): static
    {
        $this->plugins['legend']['display'] = false;

        return $this;
    }

    public function withLegend(): static
    {
        $legend = ['labels' => ['boxWidth' => 20]];
        $this->plugins['legend'] = $legend;

        return $this;
    }

    public function withLeftLegend(): static
    {
        $this->plugins['legend']['position'] = 'left';

        return $this;
    }

    public function withRightLegend(): static
    {
        $this->plugins['legend']['position'] = 'right';

        return $this;
    }

    public function withBottomLegend(): static
    {
        $this->plugins['legend']['position'] = 'bottom';

        return $this;
    }

    public function withLegendAlignToStart(): static
    {
        $this->plugins['legend']['align'] = 'start';

        return $this;
    }

    public function withLegendAlignToEnd(): static
    {
        $this->plugins['legend']['align'] = 'end';

        return $this;
    }

    public function withLegendAlignCenter(): static
    {
        $this->plugins['legend']['align'] = 'center';

        return $this;
    }

    public function withPadding(int $padding = 10): static
    {
        $this->layout['padding'] = $padding;

        return $this;
    }

    public function withPaddingLeftAndRight(int $padding = 10): static
    {
        $this->layout['padding']['left'] = $padding;
        $this->layout['padding']['right'] = $padding;

        return $this;
    }

    public function withTitle(?string $title = null): static
    {
        if (is_null($title)) {
            return $this;
        }

        $titleOptions = [
            'display' => true,
            'text' => $title
        ];

        $this->plugins['title'] = $titleOptions;

        return $this;
    }

    public function toArray(): array
    {
        return (array) $this;
    }
}
