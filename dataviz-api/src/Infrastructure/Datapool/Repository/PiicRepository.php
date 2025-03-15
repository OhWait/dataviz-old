<?php

declare(strict_types=1);

namespace App\Infrastructure\Datapool\Repository;

use App\Domain\Datapool\Model\AdministrativeDivision\Piic;
use App\Domain\Datapool\Repository\PiicRepositoryInterface;
use App\Shared\Application\Query\PaginatedQueryInterface;
use App\Shared\Infrastructure\Doctrine\DoctrineRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends DoctrineRepository<Piic>
 */
class PiicRepository extends DoctrineRepository implements PiicRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Piic::class);
    }

    protected function items(PaginatedQueryInterface $query): array
    {
        $qb = $this->createQueryBuilder('p');

        if ($query->label) {
            $qb
                ->andWhere('LOWER(p.label.value) LIKE LOWER(:label)')
                ->setParameter('label', "%{$query->label}%");
        }

        $results = $qb
            ->leftJoin('p.affiliations', 'a')
            ->addSelect('COUNT(a) AS nb')
            ->groupBy('p')
            ->getQuery()
            ->setFirstResult(($query->page() - 1) * $query->itemsPerPage())
            ->setMaxResults($query->itemsPerPage())
            ->getResult();

        return array_map(
            fn(array $result) => new Piic(
                $result[0]->year(),
                $result[0]->code(),
                $result[0]->label(),
                $result[0]->nature(),
                $result['nb'],
            ),
            $results,
        );
    }
}
