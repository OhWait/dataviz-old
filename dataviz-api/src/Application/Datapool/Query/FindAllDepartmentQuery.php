<?php

declare(strict_types=1);

namespace App\Application\Datapool\Query;

use App\Shared\Application\Query\AbstractPaginatedQuery;

final readonly class FindAllDepartmentQuery extends AbstractPaginatedQuery
{
    public function __construct(
        int $page,
        int $itemsPerPage,
        public ?string $label = null,
    ) {
        parent::__construct($page, $itemsPerPage);
    }
}
