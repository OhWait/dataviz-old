<?php

declare(strict_types=1);

namespace App\Application\Dataviz\Query\Dataset;

use App\Domain\Dataviz\ValueObject\Dataset\DatasetSlug;

final readonly class FindDatasetQuery
{
    public function __construct(
        public DatasetSlug $slug,
    ) {
    }
}
