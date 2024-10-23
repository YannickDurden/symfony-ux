<?php

namespace App\Controller;

use App\Client\SpacexClient;
use App\Manager\SpacexManager;
use App\Repository\RocketRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SpacexController extends AbstractController
{
    public function __construct(
        private readonly SpacexClient $spacexClient,
        private readonly SpacexManager $spacexManager,
        private readonly RocketRepository $rocketRepository,
    ) {
    }

    #[Route(path: '/rockets', name: 'get_rockets', methods: ['GET'])]
    public function getRockets(): Response
    {
        sleep(1);

        $rockets = $this->rocketRepository->findAll();

        return $this->render('spacex/rockets.html.twig', [
            'rockets' => $rockets,
        ]);
    }

    #[Route(path: '/rocket/{id}', name: 'get_rocket_by_id', methods: ['GET'])]
    public function getRocketById(string $id): Response
    {
        $rocket = $this->spacexClient->fetchRocketById($id);

        return $this->render('spacex/rocket.html.twig', [
            'rocket' => $rocket,
        ]);
    }

    #[Route(path: '/past-launches', name: 'get_past_launches', methods: ['GET'])]
    public function getPastLaunches(Request $request): Response
    {
        //sleep(2);

        $pastLaunchesPaginated = $this->spacexManager->paginatePastLaunches(
            page: $request->query->getInt('page', 1)
        );

        return $this->render('spacex/past-launches.html.twig', [
            'pagination' => $pastLaunchesPaginated,
        ]);
    }

    #[Route(path: '/past-launches-statistics', name: 'get_past_launches_statistics', methods: ['GET'])]
    public function pastLaunchesStatistic(): Response
    {
        sleep(2);
        return $this->render('spacex/past_launches_statistics.html.twig', [
            'chart' => $this->spacexManager->createLaunchesSuccessChart(),
        ]);
    }

    #[Route(path: '/rockets-statistics', name: 'get_rockets_statistics', methods: ['GET'])]
    public function rocketsStatistics(): Response
    {
        sleep(3);
        return $this->render('spacex/rockets_statistics.html.twig', [
            'chart' => $this->spacexManager->createRocketsStatisticsChart()
        ]);
    }
}
