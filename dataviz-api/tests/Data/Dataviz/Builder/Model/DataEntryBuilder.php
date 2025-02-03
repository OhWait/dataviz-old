<?php

declare(strict_types=1);

namespace App\Tests\Data\Dataviz\Builder\Model;

use App\Domain\Dataviz\Enum\MetaColumn\DataTypeEnum;
use App\Domain\Dataviz\Model\DataEntry;
use App\Domain\Dataviz\Model\MetaColumn;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntrySchemaName;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntrySlug;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntryTableName;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnCharacterMaximumLength;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnColumnName;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnDataType;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnLabel;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnNullable;
use App\Tests\Data\Dataviz\Factory\DataEntryFactory;

class DataEntryBuilder
{
    private ?DataEntrySlug $slug = null;
    private ?DataEntrySchemaName $schemaName = null;
    private ?DataEntryTableName $tableName = null;

    /** @var ?MetaColumn[] */
    private ?array $metaColumns = [];

    public function withSlug(?string $slug = null): self
    {
        if ($slug) {
            $this->slug = new DataEntrySlug($slug);
        }

        return $this;
    }

    public function withMetaColumns(?array $metaColumns)
    {
        $this->metaColumns = $metaColumns;

        return $this;
    }

    public function addMetaColumn(
        string $columnName = 'columnName',
        ?DataTypeEnum $dataType = DataTypeEnum::CHARACTER_VARYING,
    ): self {
        if (null === $dataType) {
            $dataType = DataTypeEnum::CHARACTER_VARYING;
        }

        $this->metaColumns[] = new MetaColumn(
            columnName: new MetaColumnColumnName($columnName),
            nullable: new MetaColumnNullable(false),
            dataType: new MetaColumnDataType($dataType->value),
            characterMaximumLength: new MetaColumnCharacterMaximumLength(null),
            label: new MetaColumnLabel('label'),
        );

        return $this;
    }

    public function build(): DataEntry
    {
        $dataEntry = DataEntryFactory::createOne(\array_filter([
            'slug' => $this->slug,
            'schemaName' => $this->schemaName,
            'tableName' => $this->tableName,
        ]));

        \array_map(
            fn (MetaColumn $metaColumn) => $metaColumn->update(dataEntry: $dataEntry),
            $this->metaColumns,
        );

        $dataEntry->update(metaColumns: $this->metaColumns);

        return $dataEntry;
    }
}
