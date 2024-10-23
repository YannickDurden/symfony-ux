<?php

namespace App\Command;

use App\Entity\Rocket;
use App\Entity\PastLaunch;
use App\Client\SpacexClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:import-spacex-past-launches',
)]
class ImportSpacexPastLaunchesCommand extends Command
{
    public function __construct(
        private readonly SpacexClient $spacexClient,
        private readonly EntityManagerInterface $entityManager,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->note('Start import...');

        $pastLaunches = $this->spacexClient->fetchPastLaunches(limit: 100);

        foreach ($pastLaunches as $pastLaunch) {
            try {
                $launchDate = date_create($pastLaunch->date_utc);
            } catch (\Exception $e) {
                $io->error($e->getMessage());

                return Command::FAILURE;
            }

            $rocketRepository = $this->entityManager->getRepository(Rocket::class);
            $rocket = $rocketRepository->findOneByApiId($pastLaunch->rocket);

            $_pastLaunch = (new PastLaunch())
                ->setName($pastLaunch->name)
                ->setDetails($pastLaunch->details)
                ->setPatch($pastLaunch->links->patch->small)
                ->setSuccess($pastLaunch->success ?? false)
                ->setLaunchDate($launchDate)
                ->setRocket($rocket);

            $this->entityManager->persist($_pastLaunch);
        }

        $this->entityManager->flush();

        $io->success('Past launches has been imported !');

        return Command::SUCCESS;
    }
}
