<?php

declare(strict_types=1);

namespace App\Domain\Datapool\Model\Chart\Request;

use App\Domain\Datapool\Enum\Chart\OperationTypeEnum;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntrySlug;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnColumnName;
use App\Shared\Domain\Model\ColumnChartTrait;
use App\Shared\Domain\Model\RequestColumnInterface;
use App\Shared\Domain\Model\RequestColumnOverrideInterface;

class AxisOperation implements RequestColumnInterface, RequestColumnOverrideInterface
{
    use ColumnChartTrait;

    public function __construct(
        protected MetaColumnColumnName $column,
        protected ?DataEntrySlug $dataEntrySlug,
        private ?OperationTypeEnum $operationType,
    ) {
    }

    public function operationType(): ?OperationTypeEnum
    {
        return $this->operationType;
    }

    public function setOperationType(OperationTypeEnum $operationType): self
    {
        $this->operationType = $operationType;

        return $this;
    }

    public function isNotAggregable(): bool
    {
        return !$this->meta()?->dataType()->isAggregable();
    }

    public function isStrictAggregable(): bool
    {
        return OperationTypeEnum::isStrictAggregableOperation($this->operationType);
    }

    public function isAnImpossibleAggregation(): bool
    {
        return $this->isNotAggregable() && $this->isStrictAggregable();
    }
}
