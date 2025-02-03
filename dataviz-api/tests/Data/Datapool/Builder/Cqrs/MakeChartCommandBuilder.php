<?php

declare(strict_types=1);

namespace App\Tests\Data\Datapool\Builder\Cqrs;

use App\Application\Datapool\Command\Chart\MakeChartCommand;
use App\Domain\Datapool\Enum\Chart\OperationTypeEnum;
use App\Domain\Datapool\Enum\Chart\ViewEnum;
use App\Domain\Datapool\Model\Chart\Filter;
use App\Domain\Datapool\Model\Chart\Request\AxisDistribution;
use App\Domain\Datapool\Model\Chart\Request\AxisOperation;
use App\Domain\Datapool\Model\Chart\Request\Serie;
use App\Domain\Datapool\ValueObject\Chart\FilterValue;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntrySlug;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetSlug;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnColumnName;

class MakeChartCommandBuilder
{
    private string $slug = 'slug';
    private ?AxisOperation $values = null;
    private ?AxisOperation $axisOperation = null;
    private ?AxisDistribution $axisDistribution = null;
    private ?Serie $serie = null;
    /**
     * @var Filter[]
     */
    private array $filters = [];

    private ViewEnum $view = ViewEnum::CARTESIAN;

    public function withView(ViewEnum $view): self
    {
        $this->view = $view;

        return $this;
    }

    public function withValues(
        string $column,
        ?string $dataEntry = null,
    ): self {
        $this->values = new AxisOperation(
            column: new MetaColumnColumnName($column),
            dataEntrySlug: null !== $dataEntry ? new DataEntrySlug($dataEntry) : null,
            operationType: null,
        );

        return $this;
    }

    public function withAxisOperation(
        string $column,
        ?string $dataEntry = null,
        ?OperationTypeEnum $operationType = null,
    ): self {
        $this->axisOperation = new AxisOperation(
            column: new MetaColumnColumnName($column),
            dataEntrySlug: null !== $dataEntry ? new DataEntrySlug($dataEntry) : null,
            operationType: $operationType,
        );

        return $this;
    }

    public function withAxisDistribution(
        string $column,
        ?string $dataEntrySlug = null,
        ?OperationTypeEnum $dateOperation = null,
    ): self {
        $this->axisDistribution = new AxisDistribution(
            column: new MetaColumnColumnName($column),
            dataEntrySlug: null !== $dataEntrySlug ? new DataEntrySlug($dataEntrySlug) : null,
            dateOperation: $dateOperation,
        );

        return $this;
    }

    public function withSerie(
        string $column,
        ?string $dataEntrySlug = null,
    ): self {
        $this->serie = new Serie(
            column: new MetaColumnColumnName($column),
            dataEntrySlug: null !== $dataEntrySlug ? new DataEntrySlug($dataEntrySlug) : null,
        );

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

    public function build(): MakeChartCommand
    {
        return new MakeChartCommand(
            slug: new DatasetSlug($this->slug),
            values: $this->values,
            axisOperation: $this->axisOperation,
            axisDistribution: $this->axisDistribution,
            serie: $this->serie,
            filters: $this->filters,
            view: $this->view,
        );
    }
}
