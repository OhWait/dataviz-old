<?php

declare(strict_types=1);

namespace App\Domain\Datapool\Repository;

use App\Domain\Dataviz\Model\DataEntry;
use App\Shared\Application\Query\PaginatedQueryInterface;
use App\Shared\Domain\Repository\PaginatorInterface;

interface PaginatedRepositoryInterface
{
    public function paginate(
        PaginatedQueryInterface $query,
        DataEntry $entry,
        bool $countTotalItems = true,
    ): PaginatorInterface;
}
