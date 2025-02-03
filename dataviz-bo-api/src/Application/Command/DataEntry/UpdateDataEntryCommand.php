<?php

declare(strict_types=1);

namespace App\Application\Command\DataEntry;

use App\Domain\ValueObject\DataEntry\DataEntrySchemaName;
use App\Domain\ValueObject\DataEntry\DataEntrySlug;
use App\Domain\ValueObject\DataEntry\DataEntryTableName;
use App\Domain\ValueObject\DataEntry\DataEntryTitle;

final readonly class UpdateDataEntryCommand
{
    public function __construct(
        public DataEntrySlug $slug,
        public ?DataEntryTitle $title = null,
        public ?DataEntrySchemaName $schemaName = null,
        public ?DataEntryTableName $tableName = null,
    ) {
    }
}
