<?php

declare(strict_types=1);

namespace App\Infrastructure\Datapool\Repository;

use App\Application\Datapool\Query\FindAllMunicipalityQuery;
use App\Domain\Datapool\Model\AdministrativeDivision\Municipality;
use App\Domain\Datapool\Repository\MunicipalityRepositoryInterface;
use App\Shared\Application\Query\PaginatedQueryInterface;
use App\Shared\Infrastructure\Doctrine\DoctrineRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends DoctrineRepository<Municipality>
 */
class MunicipalityRepository extends DoctrineRepository implements MunicipalityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Municipality::class);
    }

    /**
     * @param FindAllMunicipalityQuery $query
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

        return $qb
            ->andWhere(sprintf("%s.typecom.value = 'COM'", $alias));
    }

    protected function withOrderBy(
        QueryBuilder $qb,
        string $alias,
        PaginatedQueryInterface $query,
    ): QueryBuilder {
        return $qb->orderBy(sprintf('%s.label.value', $alias), 'ASC');
    }
}
