<?php

namespace App\Manager;

use App\Chart\ChartData;
use App\Chart\ChartDataset;
use App\Chart\ChartOptions;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;

readonly class ChartManager
{
    public function __construct(
        public ChartBuilderInterface $chartBuilder
    ) {
    }

    public function createChart(
        array $chartData,
        string $type = Chart::TYPE_DOUGHNUT,
        ?ChartOptions $chartOptions = null,
    ): ?Chart {
        if (empty($chartData['data'])) {
            return null;
        }

        $dataset = (new ChartDataset())
            ->setData($chartData['data']);

        if (isset($chartData['backgroundColor'])) {
            $dataset->setBackgroundColor($chartData['backgroundColor']);
        }

        if ($type === Chart::TYPE_BAR) {
            $dataset->withBarThickness(
                thickness: 50
            );
        }

        $data = (new ChartData())
            ->setLabels($chartData['labels'])
            ->addDataset($dataset);

        if (is_null($chartOptions)) {
            $chartOptions = (new ChartOptions())
                ->withLegend()
                ->withAspectRatio()
                ->withBottomLegend()
                ->withLegendAlignCenter();
        }

        return $this->chartBuilder
            ->createChart($type)
            ->setData($data->toArray())
            ->setOptions($chartOptions->toArray());
    }
}
