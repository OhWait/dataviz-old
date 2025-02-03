<?php

declare(strict_types=1);

namespace App\Tests\Data\Dataviz\Builder\Model;

use App\Domain\Dataviz\Enum\MetaColumn\DataTypeEnum;
use App\Domain\Dataviz\Model\DataEntry;
use App\Domain\Dataviz\Model\Dataset;
use App\Tests\Data\Dataviz\Factory\DatasetFactory;

class DatasetBuilder
{
    /**
     * @var ?DataEntry[]
     */
    private ?array $dataEntries = null;
    private readonly DataEntryBuilder $dataEntryBuilder;

    public function __construct()
    {
        $this->dataEntryBuilder = new DataEntryBuilder();
    }

    public function addDataEntry(?string $slug = null): self
    {
        $this->dataEntries[] = $this->dataEntryBuilder
            ->withSlug($slug)
            ->build();

        return $this;
    }

    public function addMetaColumn(
        string $column,
        ?DataTypeEnum $dataType = null,
    ): self {
        $this->dataEntryBuilder->addMetaColumn(
            $column,
            $dataType,
        );

        return $this;
    }

    public function build(): Dataset
    {
        $dataset = DatasetFactory::createOne();

        $dataset->update(dataEntries: $this->dataEntries);

        return $dataset;
    }
}
