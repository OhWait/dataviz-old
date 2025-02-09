<?php

declare(strict_types=1);

namespace App\Tests\Data\Dataviz\Builder\Model;

use App\Domain\Dataviz\Enum\MetaColumn\DataTypeEnum;
use App\Domain\Dataviz\Model\DataEntry;
use App\Domain\Dataviz\Model\MetaColumn;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntrySlug;
use App\Tests\Data\Dataviz\Factory\DataEntryFactory;

class DataEntryBuilder
{
    private ?DataEntrySlug $slug = null;

    /** 
     * @var MetaColumn[] 
     */
    private array $metaColumns = [];

    private readonly MetaColumnBuilder $metaColumnBuilder;

    public function __construct()
    {
        $this->metaColumnBuilder = new MetaColumnBuilder();
    }

    public function withSlug(?string $slug = null): self
    {
        if ($slug) {
            $this->slug = new DataEntrySlug($slug);
        }

        return $this;
    }

    public function addMetaColumn(
        string $columnName = 'columnName',
        ?DataTypeEnum $dataType = DataTypeEnum::CHARACTER_VARYING,
    ): self {
        if (null === $dataType) {
            $dataType = DataTypeEnum::CHARACTER_VARYING;
        }

        $this->metaColumns[] = $this->metaColumnBuilder
            ->withColumnName($columnName)
            ->withDataType($dataType)
            ->build();

        return $this;
    }

    public function build(): DataEntry
    {
        $dataEntry = DataEntryFactory::createOne(\array_filter([
            'slug' => $this->slug,
        ]));

        return new DataEntry(
            slug: $dataEntry->slug(),
            title: $dataEntry->title(),
            schemaName: $dataEntry->schemaName(),
            tableName: $dataEntry->tableName(),
            dataset: $dataEntry->dataset(),
            metaColumns: $this->metaColumns,
        );
    }
}
