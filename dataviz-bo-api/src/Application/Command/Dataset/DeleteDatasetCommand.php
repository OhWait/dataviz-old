<?php

declare(strict_types=1);

namespace App\Application\Command\Dataset;

use App\Domain\ValueObject\Dataset\DatasetSlug;

final readonly class DeleteDatasetCommand
{
    public function __construct(
        public DatasetSlug $slug,
    ) {
    }
}
