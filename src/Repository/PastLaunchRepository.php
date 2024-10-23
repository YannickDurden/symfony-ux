<?php

namespace App\Repository;

use App\Entity\PastLaunch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PastLaunch>
 */
class PastLaunchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PastLaunch::class);
    }

    public function getStatistics(): array
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->select('
                COUNT(p) AS total,
                p.success
            ')
            ->groupBy('p.success');

        return $qb->getQuery()->getArrayResult();
    }
}
