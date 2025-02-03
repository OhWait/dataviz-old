<?php

declare(strict_types=1);

namespace App\Application\Dataviz\Query\DataEntry;

use App\Domain\Dataviz\ValueObject\DataEntry\DataEntrySlug;

final readonly class FindDataEntryQuery
{
    public function __construct(
        public DataEntrySlug $slug,
    ) {
    }
}
