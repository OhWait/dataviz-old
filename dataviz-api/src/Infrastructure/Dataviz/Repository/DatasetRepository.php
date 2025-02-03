<?php

declare(strict_types=1);

namespace App\Infrastructure\Dataviz\Repository;

use App\Domain\Dataviz\Model\Dataset;
use App\Domain\Dataviz\Repository\DatasetRepositoryInterface;
use App\Shared\Infrastructure\Doctrine\DoctrineRepository;
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

    public function findWithMeta(string $slug): ?Dataset
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
}
