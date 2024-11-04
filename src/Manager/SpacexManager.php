<?php

namespace App\Manager;

use App\Chart\ChartOptions;
use App\Chart\ChartColorsEnum;
use Symfony\UX\Chartjs\Model\Chart;
use App\Repository\RocketRepository;
use App\Repository\PastLaunchRepository;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;

readonly class SpacexManager
{
    public function __construct(
        private ChartManager $chartManager,
        private PaginatorInterface $paginator,
        private RocketRepository $rocketRepository,
        private PastLaunchRepository $pastLaunchRepository,
    ) {
    }

    public function paginatePastLaunches(int $page = 1, ?string $launchName = null): PaginationInterface
    {
        $qb = $this->pastLaunchRepository->createQueryBuilder('pl');

        if ($launchName) {
            $launchNameLikeTheSearchedName = $qb->expr()->like(
                $qb->expr()->lower('pl.name'),
                $qb->expr()->literal('%' . strtolower($launchName) . '%')
            );

            $qb->andWhere($launchNameLikeTheSearchedName);
        }

        $qb->addOrderBy('pl.launchDate', 'desc');

        return $this->paginator->paginate(
            target: $qb,
            page: $page,
            limit: 5
        );
    }

    public function createLaunchesSuccessChart(): Chart
    {
        $statistics = $this->pastLaunchRepository->getStatistics();

        $data = [
            'success' => 0,
            'failure' => 0,
        ];

        foreach ($statistics as $statistic) {
            if ($statistic['success']) {
                $data['success'] += $statistic['total'];
            } else {
                $data['failure'] += $statistic['total'];
            }
        }

        $chartData = [
            'labels' => [...array_keys($data)],
            'backgroundColor' => [
                ChartColorsEnum::green->value,
                ChartColorsEnum::red->value,
            ],
            'data' => [...array_values($data)],
        ];

        $chartOptions = (new ChartOptions())
            ->withAspectRatio()
            ->withLegend()
            ->withBottomLegend()
            ->withTitle('Success by rocket');

        return $this->chartManager->createChart(
            chartData: $chartData,
            chartOptions: $chartOptions
        );
    }

    public function createRocketsStatisticsChart(): Chart
    {
        $statistics = $this->rocketRepository->getRocketsStatistics();

        $labels = array_map(static fn ($rocket) => $rocket['name'], $statistics);
        $data = array_map(static fn ($rocket) => $rocket['total'], $statistics);

        $chartData = [
            'data' => $data,
            'labels' => $labels,
            'backgroundColor' => [
                ChartColorsEnum::orange->value,
                ChartColorsEnum::blue->value,
                ChartColorsEnum::grey->value,
            ],
        ];

        $chartOptions = (new ChartOptions())
            ->withAspectRatio()
            ->withoutLegend()
            ->withTitle('Launch by rocket');

        return $this->chartManager->createChart(
            chartData: $chartData,
            type: Chart::TYPE_BAR,
            chartOptions: $chartOptions,
        );
    }
}
