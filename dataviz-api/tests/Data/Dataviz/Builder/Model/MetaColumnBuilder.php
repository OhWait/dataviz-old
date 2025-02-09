<?php

declare(strict_types=1);

namespace App\Tests\Data\Dataviz\Builder\Model;

use App\Domain\Dataviz\Enum\MetaColumn\DataTypeEnum;
use App\Domain\Dataviz\Model\MetaColumn;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnColumnName;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnDataType;
use App\Tests\Data\Dataviz\Factory\MetaColumnFactory;

class MetaColumnBuilder
{
    private ?MetaColumnColumnName $columnName = null;
    private ?MetaColumnDataType $dataType = null;

    public function withColumnName(?string $columnName): self
    {
        if ($columnName) {
            $this->columnName = new MetaColumnColumnName($columnName);
        }

        return $this;
    }

    public function withDataType(?DataTypeEnum $dataType): self
    {
        if ($dataType) {
            $this->dataType = new MetaColumnDataType($dataType->value);
        }

        return $this;
    }

    public function build(): MetaColumn
    {
        $column = MetaColumnFactory::createOne(\array_filter([
            'columnName' => $this->columnName,
            'dataType' => $this->dataType,
        ]));

        return new MetaColumn(
            columnName: $column->columnName(),
            nullable: $column->nullable(),
            dataType: $column->dataType(),
            characterMaximumLength: $column->characterMaximumLength(),
            label: $column->label(),
            dataEntry: $column->dataEntry(),
        );
    }
}
