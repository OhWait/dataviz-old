<?php

declare(strict_types=1);

namespace App\Domain\Datapool\Model\Chart;

use App\Domain\Datapool\Model\Chart\Request\AxisDistribution;
use App\Domain\Datapool\Model\Chart\Request\AxisOperation;
use App\Domain\Datapool\Model\Chart\Request\Serie;
use App\Domain\Dataviz\Model\DataEntry;
use App\Shared\Domain\Model\RequestColumnInterface;
use App\Shared\Domain\Model\RequestColumnOverrideInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Request
{
    /** @var Collection<int, Filter> */
    private Collection $filters;

    /** @var Collection<int, DataEntry> */
    private Collection $dataEntries;

    /**
     * @param Filter[]    $filters
     * @param DataEntry[] $dataEntries
     */
    public function __construct(
        private ?AxisOperation $values = null,
        private ?AxisOperation $axisOperation = null,
        private ?AxisDistribution $axisDistribution = null,
        private ?Serie $serie = null,
        array $filters = [],
        array $dataEntries = [],
    ) {
        $this->filters = new ArrayCollection($filters);
        $this->dataEntries = new ArrayCollection($dataEntries);
    }

    public function values(): ?AxisOperation
    {
        return $this->values;
    }

    public function axisOperation(): ?AxisOperation
    {
        return $this->axisOperation;
    }

    public function axisDistribution(): ?AxisDistribution
    {
        return $this->axisDistribution;
    }

    public function serie(): ?Serie
    {
        return $this->serie;
    }

    public function hasSerie(): bool
    {
        return null !== $this->serie;
    }

    /**
     * @return array<string, RequestColumnInterface&RequestColumnOverrideInterface>
     */
    public function protectedParams(): array
    {
        return \array_filter([
            'values' => $this->values,
            'axisDistribution' => $this->axisDistribution,
            'axisOperation' => $this->axisOperation,
            'serie' => $this->serie,
        ]);
    }

    /**
     * @return Collection<int, Filter>
     */
    public function filters(): Collection
    {
        return $this->filters;
    }

    /**
     * @return Collection<int, DataEntry>
     */
    public function dataEntries(): Collection
    {
        return $this->dataEntries;
    }

    public function hasOneTableRequested(): bool
    {
        return 1 === $this->dataEntries->count();
    }
}
