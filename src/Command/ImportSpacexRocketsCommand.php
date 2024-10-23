<?php

namespace App\Command;

use App\Client\SpacexClient;
use App\Entity\Rocket;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import-spacex-rockets',
)]
class ImportSpacexRocketsCommand extends Command
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

        $io->note('Starting import..');

        $rockets = $this->spacexClient->fetchRockets();

        foreach ($rockets as $rocket) {
            $_rocket = (new Rocket())
                ->setName($rocket->name)
                ->setType($rocket->type)
                ->setHeight($rocket->height['meters'])
                ->setMass($rocket->mass['kg'])
                ->setActive($rocket->active)
                ->setApiId($rocket->id);

            $this->entityManager->persist($_rocket);
        }

        $this->entityManager->flush();

        $io->success('Rockets has been imported!');

        return Command::SUCCESS;
    }
}
