<?php

declare(strict_types=1);

namespace App\Domain\Datapool\Model\Chart\Request;

use App\Domain\Datapool\Enum\Chart\OperationTypeEnum;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntrySlug;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnColumnName;
use App\Shared\Domain\Model\ColumnChartTrait;
use App\Shared\Domain\Model\RequestColumnInterface;
use App\Shared\Domain\Model\RequestColumnOverrideInterface;

class AxisDistribution implements RequestColumnInterface, RequestColumnOverrideInterface
{
    use ColumnChartTrait;

    public function __construct(
        protected MetaColumnColumnName $column,
        protected ?DataEntrySlug $dataEntrySlug,
        private ?OperationTypeEnum $dateOperation,
    ) {
    }

    public function dateOperation(): ?OperationTypeEnum
    {
        return $this->dateOperation;
    }

    public function removeDateOperation(): self
    {
        $this->dateOperation = null;

        return $this;
    }

    public function isNotDateAggregable(): bool
    {
        return !$this->meta()?->dataType()->isDateAggregable();
    }
}
