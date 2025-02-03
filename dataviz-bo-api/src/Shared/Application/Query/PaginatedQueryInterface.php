<?php

declare(strict_types=1);

namespace App\Shared\Application\Query;

interface PaginatedQueryInterface
{
    public function getPage(): int;

    public function getItemsPerPage(): int;

    public function getOffset(): int;
}
