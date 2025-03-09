<?php

declare(strict_types=1);

namespace App\Infrastructure\Datapool\Repository;

use App\Application\Datapool\Query\FindAllDepartmentQuery;
use App\Domain\Datapool\Model\AdministrativeDivision\Department;
use App\Domain\Datapool\Repository\DepartmentRepositoryInterface;
use App\Shared\Application\Query\PaginatedQueryInterface;
use App\Shared\Infrastructure\Doctrine\DoctrineRepository;
use Doctrine\ORM\QueryBuilder;
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

    /**
     * @param FindAllDepartmentQuery $query
     */
    protected function withFilters(
        QueryBuilder $qb,
        string $alias,
        mixed $query,
    ): QueryBuilder {
        if ($query->label) {
            $qb
                ->andWhere(sprintf('LOWER(%s.label.value) LIKE LOWER(:label)', $alias))
                ->setParameter('label', "%{$query->label}%");
        }

        return $qb;
    }

    protected function withOrderBy(
        QueryBuilder $qb,
        string $alias,
        PaginatedQueryInterface $query,
    ): QueryBuilder {
        return $qb->orderBy(sprintf('%s.label.value', $alias), 'ASC');
    }
}
