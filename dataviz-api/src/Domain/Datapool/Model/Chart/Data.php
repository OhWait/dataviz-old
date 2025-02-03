<?php

declare(strict_types=1);

namespace App\Domain\Datapool\Model\Chart;

class Data
{
    public function __construct(
        private float $y,
        private int|float|string|null $x = null,
        private ?string $label = null,
    ) {
    }

    public function y(): float
    {
        return $this->y;
    }

    public function x(): int|float|string|null
    {
        return $this->x;
    }

    public function label(): ?string
    {
        return $this->label;
    }
}
