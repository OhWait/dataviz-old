<?php

declare(strict_types=1);

namespace App\Domain\Datapool\UseCase\Chart;

use App\Application\Datapool\Command\Chart\MakeChartCommand;
use App\Domain\Datapool\Enum\Chart\OperationTypeEnum;
use App\Domain\Datapool\Model\Chart\Request;
use App\Domain\Datapool\Model\Chart\Request\AxisDistribution;
use App\Domain\Datapool\Model\Chart\Request\AxisOperation;
use App\Domain\Dataviz\Model\DataEntry;
use App\Domain\Dataviz\Model\Dataset;
use App\Domain\Dataviz\Model\MetaColumn;
use App\Shared\Domain\Model\RequestColumnOverrideInterface;

final class RequestBuilder
{
    /**
     * @var array<string, DataEntry>
     */
    private array $dataEntries = [];

    public function __construct(readonly private Dataset $dataset)
    {
    }

    public function build(MakeChartCommand $command): Request
    {
        if ($command->axisDistribution) {
            $this
                ->setDataEntry($command->axisDistribution)
                ->setMeta($command->axisDistribution, $command)
                ->setDateOperationType($command->axisDistribution);
        }

        if ($command->values) {
            $this
                ->setDataEntry($command->values)
                ->setMeta($command->values, $command);
        }

        if ($command->axisOperation) {
            $this
                ->setDataEntry($command->axisOperation)
                ->setMeta($command->axisOperation, $command)
                ->setOperationType($command->axisOperation);
        }

        if ($command->serie) {
            $this
                ->setDataEntry($command->serie)
                ->setMeta($command->serie, $command);
        }

        foreach ($command->filters as $index => $filter) {
            $this
                ->setDataEntry($filter)
                ->setMeta($filter, $command, $index);
        }

        return new Request(
            values: $command->values,
            axisOperation: $command->axisOperation,
            axisDistribution: $command->axisDistribution,
            serie: $command->serie,
            filters: $command->filters,
            dataEntries: $this->dataEntries,
        );
    }

    private function setDataEntry(RequestColumnOverrideInterface $command): self
    {
        $entry = null;

        if (1 === $this->dataset->dataEntries()->count()) {
            $entry = $this->dataset->dataEntries()->first();
        } else {
            $entry = $this->dataset->dataEntries()->findFirst(
                fn (int $key, DataEntry $dataEntry) => $command->dataEntrySlug()?->equals($dataEntry->slug()),
            );
        }

        if (null !== $entry) {
            $command->setDataEntry($entry)->setDataEntrySlug($entry->slug());
        }

        return $this;
    }

    private function setMeta(
        RequestColumnOverrideInterface $param,
        MakeChartCommand $command,
        ?int $index = null,
    ): self {
        $meta = $param
            ->dataEntry()
            ?->metaColumns()
            ->findFirst(function (int $key, MetaColumn $meta) use ($param) {
                return $param->column()->equals($meta->columnName());
            });

        if (null !== $meta) {
            $param->setMeta($meta);
            $this->saveDataEntry($meta->dataEntry());

            return $this;
        }

        if (null !== $index) {
            $command->removeFilter($index);
        }

        return $this;
    }

    /**
     * Set a default operation type if the user send an impossible operation.
     */
    private function setOperationType(AxisOperation $param): self
    {
        if (null === $param->operationType()) {
            return $this;
        }

        if ($param->isAnImpossibleAggregation()) {
            $param->setOperationType(OperationTypeEnum::COUNT);
        }

        return $this;
    }

    private function setDateOperationType(AxisDistribution $param): self
    {
        if (null === $param->dateOperation()) {
            return $this;
        }

        if ($param->isNotDateAggregable()) {
            $param->removeDateOperation();
        }

        return $this;
    }

    private function saveDataEntry(DataEntry $dataEntry): self
    {
        $this->dataEntries[$dataEntry->slug()->value] = $dataEntry;

        return $this;
    }
}
