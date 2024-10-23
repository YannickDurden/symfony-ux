<?php

namespace App\Repository;

use App\Entity\Rocket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Rocket>
 */
class RocketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rocket::class);
    }

    public function getRocketsStatistics(): array
    {
        $qb = $this->createQueryBuilder('r');

        $qb
            ->select('count(pastLaunches) as total, r.name ')
            ->innerJoin('r.pastLaunches', 'pastLaunches')
            ->groupBy('r.name');

        return $qb->getQuery()->getArrayResult();
    }
}
