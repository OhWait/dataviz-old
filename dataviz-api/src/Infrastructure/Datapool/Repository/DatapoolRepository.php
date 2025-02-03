<?php

declare(strict_types=1);

namespace App\Infrastructure\Datapool\Repository;

use App\Domain\Datapool\Repository\PaginatedRepositoryInterface;
use App\Domain\Dataviz\Model\DataEntry;
use App\Shared\Application\Query\PaginatedQueryInterface;
use App\Shared\Domain\Repository\PaginatorInterface;
use App\Shared\Infrastructure\ApiPlatform\Paginator;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class DatapoolRepository implements PaginatedRepositoryInterface
{
    public const CONNECTION = 'pool';

    public function __construct(protected ManagerRegistry $em)
    {
    }

    public function paginate(
        PaginatedQueryInterface $query,
        DataEntry $entry,
        bool $countTotalItems = true,
    ): PaginatorInterface {
        $data = $this->getPaginatedData($query, $entry);

        return new Paginator(
            new \ArrayObject($data),
            (float) $query->page(),
            (float) $query->itemsPerPage(),
            (float) $countTotalItems ? $this->count($entry) : 0,
        );
    }

    /**
     * @return list<array<string, mixed>>
     */
    protected function getPaginatedData(PaginatedQueryInterface $query, DataEntry $entry): array
    {
        return $this
            ->getQueryBuidler()
            ->select('*')
            ->from($entry->fullTableName())
            ->setMaxResults($query->itemsPerPage())
            ->setFirstResult($query->offset())
            ->executeQuery()
            ->fetchAllAssociative();
    }

    protected function count(DataEntry $entry): int
    {
        return $this
            ->getQueryBuidler()
            ->select('count(*)')
            ->from($entry->fullTableName())
            ->executeQuery()
            ->fetchOne();
    }

    protected function getQueryBuidler(): QueryBuilder
    {
        return $this->getConnection()->createQueryBuilder();
    }

    protected function getConnection(): Connection
    {
        return $this->em->getConnection(self::CONNECTION);
    }
}
