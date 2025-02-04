<?php

declare(strict_types=1);

namespace App\Application\Datapool\Query;

use App\Domain\Dataviz\ValueObject\DataEntry\DataEntrySlug;
use App\Shared\Application\Query\AbstractPaginatedQuery;

final readonly class FindPaginatedDataQuery extends AbstractPaginatedQuery
{
    public function __construct(
        public DataEntrySlug $slug,
        int $page,
        int $limit,
    ) {
        parent::__construct($page, $limit);
    }
}
