<?php

declare(strict_types=1);

namespace App\Shared\Application\Query;

abstract readonly class AbstractPaginatedQuery implements PaginatedQueryInterface
{
    public function __construct(
        protected int $page,
        protected int $itemsPerPage,
    ) {
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    public function getOffset(): int
    {
        return ($this->getPage() - 1) * $this->itemsPerPage;
    }
}
