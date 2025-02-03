<?php

declare(strict_types=1);

namespace App\Application\Query\Dataset;

use App\Domain\ValueObject\Dataset\DatasetSlug;

final readonly class FindDatasetQuery
{
    public function __construct(
        public DatasetSlug $slug,
    ) {
    }
}
