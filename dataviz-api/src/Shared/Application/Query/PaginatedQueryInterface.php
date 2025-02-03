<?php

declare(strict_types=1);

namespace App\Shared\Application\Query;

interface PaginatedQueryInterface
{
    public function page(): int;

    public function itemsPerPage(): int;

    public function offset(): int;
}
