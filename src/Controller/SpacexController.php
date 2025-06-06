<?php

namespace App\Controller;

use App\Manager\SpacexManager;
use App\Repository\RocketRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SpacexController extends AbstractController
{
    public function __construct(
        private readonly SpacexManager $spacexManager,
        private readonly RocketRepository $rocketRepository,
    ) {
    }

    #[Route(path: '/spacex', name: 'spacex', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('spacex/index.html.twig');
    }

    #[Route(path: '/rockets', name: 'get_rockets', methods: ['GET'])]
    public function getRockets(): Response
    {
        $rockets = $this->rocketRepository->findAll();

        return $this->render('spacex/rockets.html.twig', [
            'rockets' => $rockets,
        ]);
    }

    #[Route(path: '/rocket/{id}', name: 'get_rocket_by_id', methods: ['GET'])]
    public function getRocketById(string $id): Response
    {
        return $this->render('spacex/rocket.html.twig', ['id' => $id]);
    }

    #[Route(path: '/past-launches', name: 'get_past_launches', methods: ['GET'])]
    public function getPastLaunches(Request $request): Response
    {
        $launchName = $request->query->get('launchName');

        $pastLaunchesPaginated = $this->spacexManager->paginatePastLaunches(
            page: $request->query->getInt('page', 1),
            launchName: $launchName,
        );

        return $this->render('spacex/past-launches.html.twig', [
            'pagination' => $pastLaunchesPaginated,
            'launchName' => $launchName,
        ]);
    }

    #[Route(path: '/past-launches-statistics', name: 'get_past_launches_statistics', methods: ['GET'])]
    public function pastLaunchesStatistic(): Response
    {
        return $this->render('spacex/past_launches_statistics.html.twig', [
            'chart' => $this->spacexManager->createLaunchesSuccessChart(),
        ]);
    }

    #[Route(path: '/rockets-statistics', name: 'get_rockets_statistics', methods: ['GET'])]
    public function rocketsStatistics(): Response
    {
        return $this->render('spacex/rockets_statistics.html.twig', [
            'chart' => $this->spacexManager->createRocketsStatisticsChart()
        ]);
    }
}
