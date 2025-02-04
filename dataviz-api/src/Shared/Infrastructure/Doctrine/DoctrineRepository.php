<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine;

use App\Shared\Application\Query\PaginatedQueryInterface;
use App\Shared\Domain\Repository\PaginatorInterface;
use App\Shared\Domain\Repository\RepositoryInterface;
use App\Shared\Infrastructure\ApiPlatform\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Webmozart\Assert\Assert;

/**
 * @template T of object
 *
 * @method T|null find($id, $lockMode = null, $lockVersion = null)
 * @method T|null findOneBy(array $criteria, array $orderBy = null)
 * @method T[]    findAll()
 * @method T[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @implements RepositoryInterface<T>
 *
 * @extends ServiceEntityRepository<T>
 */
abstract class DoctrineRepository extends ServiceEntityRepository implements RepositoryInterface
{
    public function __construct(
        protected ManagerRegistry $em,
        string $entityClass,
    ) {
        parent::__construct($em, $entityClass);
    }

    /**
     * @return PaginatorInterface<T>
     */
    public function paginate(PaginatedQueryInterface $query): PaginatorInterface
    {
        Assert::positiveInteger($query->page());
        Assert::positiveInteger($query->itemsPerPage());

        $qbTotal = $this->createQueryBuilder('t')->select('count(t)');
        $totalItems = $this
            ->withFilters($qbTotal, 't', $query)
            ->getQuery()
            ->getSingleScalarResult();

        return new Paginator(
            new \ArrayObject($this->items($query)),
            (float) $query->page(),
            (float) $query->itemsPerPage(),
            (float) $totalItems,
        );
    }

    protected function withFilters(QueryBuilder $qb, string $alias, PaginatedQueryInterface $query): QueryBuilder
    {
        return $qb;
    }

    protected function withOrderBy(QueryBuilder $qb, string $alias, PaginatedQueryInterface $query): QueryBuilder
    {
        return $qb;
    }

    /**
     * @return T[]
     */
    private function items(PaginatedQueryInterface $query): array
    {
        $qb = $this->createQueryBuilder('p');
        $this->withOrderBy($qb, 'p', $query);

        return $this
            ->withFilters($qb, 'p', $query)
            ->getQuery()
            ->setFirstResult(($query->page() - 1) * $query->itemsPerPage())
            ->setMaxResults($query->itemsPerPage())
            ->getResult();
    }
}
