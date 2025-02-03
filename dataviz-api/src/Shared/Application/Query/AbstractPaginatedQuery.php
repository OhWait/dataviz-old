<?php

declare(strict_types=1);

namespace App\Shared\Application\Query;

abstract class AbstractPaginatedQuery implements PaginatedQueryInterface
{
    public function __construct(
        protected int $page,
        protected int $itemsPerPage,
    ) {
    }

    public function page(): int
    {
        return $this->page;
    }

    public function itemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    public function offset(): int
    {
        return ($this->page() - 1) * $this->itemsPerPage;
    }
}
