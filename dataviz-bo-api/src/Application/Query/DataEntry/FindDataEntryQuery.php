<?php

declare(strict_types=1);

namespace App\Application\Query\DataEntry;

use App\Domain\ValueObject\DataEntry\DataEntrySlug;

final readonly class FindDataEntryQuery
{
    public function __construct(
        public DataEntrySlug $slug,
    ) {
    }
}
