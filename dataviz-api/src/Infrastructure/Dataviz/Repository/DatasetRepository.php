<?php

declare(strict_types=1);

namespace App\Infrastructure\Dataviz\Repository;

use App\Application\Dataviz\Query\Dataset\FindAllDatasetQuery;
use App\Domain\Dataviz\Model\Dataset;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetSlug;
use App\Domain\Dataviz\Repository\DatasetRepositoryInterface;
use App\Shared\Infrastructure\Doctrine\DoctrineRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends DoctrineRepository<Dataset>
 */
class DatasetRepository extends DoctrineRepository implements DatasetRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dataset::class);
    }

    public function findWithMeta(DatasetSlug $slug): ?Dataset
    {
        return $this
            ->createQueryBuilder('d')
            ->select('dataset', 'provider', 'dataEntry', 'metaColumn', 'metaRow')
            ->from(Dataset::class, 'dataset')
            ->leftJoin('dataset.provider', 'provider')
            ->leftJoin('dataset.dataEntries', 'dataEntry')
            ->leftJoin('dataEntry.metaColumns', 'metaColumn')
            ->leftJoin('metaColumn.metaRows', 'metaRow')
            ->where('dataset.slug.value = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param FindAllDatasetQuery $query
     */
    protected function withFilters(
        QueryBuilder $qb,
        string $alias,
        mixed $query,
    ): QueryBuilder {
        if ($query->withDataProvider) {
            $qb->where(sprintf('%s.dataProvider IS NOT NULL', $alias));
        }

        if ($query->hasTheme()) {
            $qb
                ->leftJoin(sprintf('%s.themes', $alias), 'th')
                ->andWhere('th.slug.value IN (:themes)')
                ->setParameter('themes', $query->themes);
        }

        return $qb;
    }
}
