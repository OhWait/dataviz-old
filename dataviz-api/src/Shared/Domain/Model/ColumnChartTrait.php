<?php

declare(strict_types=1);

namespace App\Shared\Domain\Model;

use App\Domain\Dataviz\Model\DataEntry;
use App\Domain\Dataviz\Model\MetaColumn;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntrySlug;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnColumnName;

trait ColumnChartTrait
{
    protected MetaColumnColumnName $column;
    protected ?DataEntrySlug $dataEntrySlug;
    protected ?MetaColumn $meta = null;
    protected ?DataEntry $dataEntry = null;

    public function column(): MetaColumnColumnName
    {
        return $this->column;
    }

    public function dataEntrySlug(): ?DataEntrySlug
    {
        return $this->dataEntrySlug;
    }

    public function setDataEntrySlug(DataEntrySlug $dataEntrySlug): self
    {
        $this->dataEntrySlug = $dataEntrySlug;

        return $this;
    }

    public function dataEntry(): ?DataEntry
    {
        return $this->dataEntry;
    }

    public function setDataEntry(DataEntry $dataEntry): self
    {
        $this->dataEntry = $dataEntry;

        return $this;
    }

    public function meta(): ?MetaColumn
    {
        return $this->meta;
    }

    public function setMeta(MetaColumn $meta): self
    {
        $this->meta = $meta;

        return $this;
    }

    public function fullColumnName(): string
    {
        return sprintf(
            '%s.%s',
            $this->dataEntry()->tableName(),
            $this->column(),
        );
    }
}
