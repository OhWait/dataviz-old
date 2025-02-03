<?php

declare(strict_types=1);

namespace App\Application\Command\DataEntry;

use App\Domain\ValueObject\DataEntry\DataEntrySchemaName;
use App\Domain\ValueObject\DataEntry\DataEntrySlug;
use App\Domain\ValueObject\DataEntry\DataEntryTableName;
use App\Domain\ValueObject\DataEntry\DataEntryTitle;
use App\Domain\ValueObject\Dataset\DatasetSlug;

final readonly class CreateDataEntryCommand
{
    public function __construct(
        public DataEntrySlug $slug,
        public DataEntryTitle $title,
        public DataEntrySchemaName $schemaName,
        public DataEntryTableName $tableName,
        public DatasetSlug $dataset,
    ) {
    }
}
