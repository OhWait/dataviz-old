<?php

declare(strict_types=1);

namespace App\Tests\Data\Datapool\Builder\Model\Chart;

use App\Domain\Datapool\Enum\Chart\OperationTypeEnum;
use App\Domain\Datapool\Model\Chart\Filter;
use App\Domain\Datapool\Model\Chart\Request;
use App\Domain\Datapool\Model\Chart\Request\AxisDistribution;
use App\Domain\Datapool\Model\Chart\Request\AxisOperation;
use App\Domain\Datapool\Model\Chart\Request\Serie;
use App\Domain\Datapool\ValueObject\Chart\FilterValue;
use App\Domain\Dataviz\Model\DataEntry;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntrySlug;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnColumnName;

class RequestBuilder
{
    private ?AxisOperation $values = null;
    private ?AxisOperation $axisOperation = null;
    private ?AxisDistribution $axisDistribution = null;
    private ?Serie $serie = null;
    /** @var Filter[] */
    private array $filters = [];

    public function withValues(
        string $column,
        ?string $dataEntrySlug = null,
        ?DataEntry $dataEntry = null,
    ): self {
        $this->values = new AxisOperation(
            column: new MetaColumnColumnName($column),
            dataEntrySlug: null !== $dataEntrySlug ? new DataEntrySlug($dataEntrySlug) : null,
            operationType: null,
        );

        if ($dataEntry) {
            $this->values->setDataEntry($dataEntry);
        }

        return $this;
    }

    public function withAxisOperation(
        string $column,
        ?string $dataEntrySlug = null,
        ?DataEntry $dataEntry = null,
        ?OperationTypeEnum $operationType = null,
    ): self {
        $this->axisOperation = new AxisOperation(
            column: new MetaColumnColumnName($column),
            dataEntrySlug: null !== $dataEntrySlug ? new DataEntrySlug($dataEntrySlug) : null,
            operationType: $operationType,
        );

        if ($dataEntry) {
            $this->axisOperation->setDataEntry($dataEntry);
        }

        return $this;
    }

    public function withAxisDistribution(
        string $column,
        ?string $dataEntrySlug = null,
        ?DataEntry $dataEntry = null,
        ?OperationTypeEnum $dateOperation = null,
    ): self {
        $this->axisDistribution = new AxisDistribution(
            column: new MetaColumnColumnName($column),
            dataEntrySlug: null !== $dataEntrySlug ? new DataEntrySlug($dataEntrySlug) : null,
            dateOperation: $dateOperation,
        );

        if ($dataEntry) {
            $this->axisDistribution->setDataEntry($dataEntry);
        }

        return $this;
    }

    public function withSerie(
        string $column,
        ?string $dataEntrySlug = null,
        ?DataEntry $dataEntry = null,
    ): self {
        $this->serie = new Serie(
            column: new MetaColumnColumnName($column),
            dataEntrySlug: null !== $dataEntrySlug ? new DataEntrySlug($dataEntrySlug) : null,
        );

        if ($dataEntry) {
            $this->serie->setDataEntry($dataEntry);
        }

        return $this;
    }

    /**
     * @param FilterValue[] $values
     */
    public function addFilter(
        string $column,
        ?string $dataEntrySlug = null,
        array $values = [],
    ): self {
        $this->filters[] = new Filter(
            column: new MetaColumnColumnName($column),
            dataEntrySlug: null !== $dataEntrySlug ? new DataEntrySlug($dataEntrySlug) : null,
            values: $values,
        );

        return $this;
    }

    public function setDataEntryInfoFilter(DataEntry $dataEntry, ?int $index = null): self
    {
        if (null === $index) {
            $index = \count($this->filters) - 1;
        }

        $this->filters[$index]->setDataEntry($dataEntry);

        return $this;
    }

    public function build(): Request
    {
        return new Request(
            values: $this->values,
            axisOperation: $this->axisOperation,
            axisDistribution: $this->axisDistribution,
            serie: $this->serie,
            filters: $this->filters,
        );
    }
}
