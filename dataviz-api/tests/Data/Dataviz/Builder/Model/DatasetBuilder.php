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
     * @var DataEntry[]
     */
    private array $dataEntries = [];
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

        return new Dataset(
            slug: $dataset->slug(),
            title: $dataset->title(),
            shortTitle: $dataset->shortTitle(),
            description: $dataset->description(),
            perimeter: $dataset->perimeter(),
            granularity: $dataset->granularity(),
            updateFrequency: $dataset->updateFrequency(),
            updatePeriod: $dataset->updatePeriod(),
            security: $dataset->security(),
            language: $dataset->language(),
            dataCreatedAt: $dataset->dataCreatedAt(),
            dataUpdatedAt: $dataset->dataUpdatedAt(),
            dataProvider: $dataset->dataProvider(),
            provider: $dataset->provider(),
            dataEntries: $this->dataEntries,
        );
    }
}
