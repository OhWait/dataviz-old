<?php

declare(strict_types=1);

namespace App\Shared\Domain\Repository;

use ApiPlatform\State\Pagination\PaginatorInterface as APIPaginatorInterface;

/**
 * @template T of object
 *
 * @extends APIPaginatorInterface<T>
 */
interface PaginatorInterface extends APIPaginatorInterface
{
    public function getCurrentPage(): float;

    public function getItemsPerPage(): float;

    public function getLastPage(): float;

    public function getTotalItems(): float;

    public function getIterator(): \Traversable;
}
