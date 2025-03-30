<?php

declare(strict_types=1);

namespace App\Infrastructure\Datapool\Repository;

use App\Domain\Datapool\Model\AdministrativeDivision\Department;
use App\Domain\Datapool\Repository\DepartmentRepositoryInterface;
use App\Shared\Application\Query\PaginatedQueryInterface;
use App\Shared\Infrastructure\Doctrine\DoctrineRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends DoctrineRepository<Department>
 */
class DepartmentRepository extends DoctrineRepository implements DepartmentRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Department::class);
    }

    protected function items(PaginatedQueryInterface $query): array
    {
        $qb = $this->createQueryBuilder('p');

        if ($query->label) {
            $qb
                ->andWhere('LOWER(p.libdep.value) LIKE LOWER(:libdep)')
                ->setParameter('libdep', "%{$query->label}%");
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
            fn(array $result) => new Department(
                $result[0]->year(),
                $result[0]->code(),
                $result[0]->label(),
                $result['nb'],
            ),
            $results,
        );
    }
}
