<?php

declare(strict_types=1);

namespace App\Application\Command\DataEntry;

use App\Domain\ValueObject\DataEntry\DataEntrySlug;

final readonly class DeleteDataEntryCommand
{
    public function __construct(
        public DataEntrySlug $slug,
    ) {
    }
}
