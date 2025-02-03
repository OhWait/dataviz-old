<?php

declare(strict_types=1);

namespace App\Domain\Datapool\Model\Chart;

class Serie
{
    /**
     * @param Data[] $data
     */
    public function __construct(
        private array $data,
        private ?string $label = null,
    ) {
    }

    public function label(): ?string
    {
        return $this->label;
    }

    /**
     * @return Data[]
     */
    public function data(): array
    {
        return $this->data;
    }
}
