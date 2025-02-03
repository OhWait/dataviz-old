<?php

declare(strict_types=1);

namespace App\Domain\Datapool\Model\Chart;

use App\Domain\Datapool\ValueObject\Chart\FilterValue;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntrySlug;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnColumnName;
use App\Shared\Domain\Model\ColumnChartTrait;
use App\Shared\Domain\Model\RequestColumnInterface;
use App\Shared\Domain\Model\RequestColumnOverrideInterface;

class Filter implements RequestColumnInterface, RequestColumnOverrideInterface
{
    use ColumnChartTrait;

    /**
     * @param FilterValue[] $values
     */
    public function __construct(
        protected MetaColumnColumnName $column,
        protected ?DataEntrySlug $dataEntrySlug,
        private array $values,
    ) {
    }

    public function values(): array
    {
        return $this->values;
    }

    public function whereCond(): string
    {
        $format = '%s IN (:%s)';

        if (1 === \count($this->values)) {
            $format = '%s = :%s';
        }

        return \sprintf(
            $format,
            $this->fullColumnName(),
            $this->column()->__toString(),
        );
    }

    /**
     * @return array<string, string[]>
     */
    public function whereBind(): array
    {
        return [
            $this->column->__toString() => $this->strValues(),
        ];
    }

    /**
     * @return string[]
     */
    private function strValues(): array
    {
        return \array_map(
            fn (FilterValue $value) => $value->__toString(),
            $this->values,
        );
    }
}
