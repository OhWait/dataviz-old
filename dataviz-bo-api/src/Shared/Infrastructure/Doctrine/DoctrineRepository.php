<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine;

use App\Shared\Application\Query\PaginatedQueryInterface;
use App\Shared\Domain\Repository\PaginatorInterface;
use App\Shared\Domain\Repository\RepositoryInterface;
use App\Shared\Infrastructure\ApiPlatform\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Webmozart\Assert\Assert;

/**
 * @template T of object
 *
 * @method void   save(T $entity, bool $flush = true)
 * @method void   remove(T $entity, bool $flush = true)
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
    public function save(mixed $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(mixed $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return PaginatorInterface<T>
     */
    public function paginate(PaginatedQueryInterface $query): PaginatorInterface
    {
        Assert::positiveInteger($query->getPage());
        Assert::positiveInteger($query->getItemsPerPage());

        $qbTotal = $this->createQueryBuilder('t')->select('count(t)');
        $totalItems = $this->getTotalItems($qbTotal, $query);

        return new Paginator(
            new \ArrayObject($this->getItems($query)),
            (float) $query->getPage(),
            (float) $query->getItemsPerPage(),
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

    private function getTotalItems(QueryBuilder $qb, PaginatedQueryInterface $query): int
    {
        return $this
            ->withFilters($qb, 't', $query)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @return T[]
     */
    private function getItems(PaginatedQueryInterface $query): array
    {
        $qb = $this->createQueryBuilder('p');
        $this->withOrderBy($qb, 'p', $query);

        return $this
            ->withFilters($qb, 'p', $query)
            ->getQuery()
            ->setFirstResult(($query->getPage() - 1) * $query->getItemsPerPage())
            ->setMaxResults($query->getItemsPerPage())
            ->getResult();
    }
}
