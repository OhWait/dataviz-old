<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\ApiPlatform;

use App\Shared\Domain\Repository\PaginatorInterface;

/**
 * @template T of object
 */
final readonly class Paginator implements PaginatorInterface, \IteratorAggregate
{
    /**
     * @param \Traversable<T> $items
     */
    public function __construct(
        private \Traversable $items,
        private float $currentPage,
        private float $itemsPerPage,
        private float $totalItems,
    ) {
    }

    public function getCurrentPage(): float
    {
        return $this->currentPage;
    }

    public function getItemsPerPage(): float
    {
        return $this->itemsPerPage;
    }

    public function getLastPage(): float
    {
        return ceil($this->totalItems / $this->itemsPerPage);
    }

    public function getTotalItems(): float
    {
        return $this->totalItems;
    }

    public function count(): int
    {
        return iterator_count($this->getIterator());
    }

    public function getIterator(): \Traversable
    {
        return $this->items;
    }
}
