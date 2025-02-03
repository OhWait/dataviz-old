<?php

declare(strict_types=1);

namespace App\Application\Datapool\Command\Chart;

use App\Domain\Datapool\Enum\Chart\ViewEnum;
use App\Domain\Datapool\Model\Chart\Filter;
use App\Domain\Datapool\Model\Chart\Request\AxisDistribution;
use App\Domain\Datapool\Model\Chart\Request\AxisOperation;
use App\Domain\Datapool\Model\Chart\Request\Serie;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetSlug;

final class MakeChartCommand
{
    /**
     * @param Filter[] $filters
     */
    public function __construct(
        public DatasetSlug $slug,
        public ViewEnum $view,
        public ?AxisOperation $values = null,
        public ?AxisOperation $axisOperation = null,
        public ?AxisDistribution $axisDistribution = null,
        public ?Serie $serie = null,
        public array $filters = [],
    ) {
    }

    public function removeFilter(int $index): self
    {
        array_splice($this->filters, $index, 1);

        return $this;
    }
}
