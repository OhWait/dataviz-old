<?php

declare(strict_types=1);

namespace App\Infrastructure\Datapool\Repository;

use App\Application\Datapool\Query\FindAllPiicQuery;
use App\Domain\Datapool\Model\AdministrativeDivision\Piic;
use App\Domain\Datapool\Repository\PiicRepositoryInterface;
use App\Shared\Application\Query\PaginatedQueryInterface;
use App\Shared\Infrastructure\Doctrine\DoctrineRepository;
use Doctrine\ORM\QueryBuilder;
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

    /**
     * @param FindAllPiicQuery $query
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

    protected function items(PaginatedQueryInterface $query): array
    {
        $qb = $this->createQueryBuilder('p')
            ->leftJoin('p.affiliations', 'a')
            ->addSelect('COUNT(a) AS nbMunicipalities')
            ->groupBy('p');

        $results = $this
            ->withFilters($qb, 'p', $query)
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
                $result['nbMunicipalities'],
            ),
            $results,
        );
    }
}
