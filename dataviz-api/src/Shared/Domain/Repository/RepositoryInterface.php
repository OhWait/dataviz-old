<?php

declare(strict_types=1);

namespace App\Shared\Domain\Repository;

use App\Shared\Application\Query\PaginatedQueryInterface;

/**
 * @template T of object
 *
 * @method T|null find($id, $lockMode = null, $lockVersion = null)
 * @method T|null findOneBy(array $criteria, array $orderBy = null)
 * @method T[]    findAll()
 * @method T[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface RepositoryInterface
{
    /**
     * @return PaginatorInterface<T>
     */
    public function paginate(PaginatedQueryInterface $query): PaginatorInterface;
}
