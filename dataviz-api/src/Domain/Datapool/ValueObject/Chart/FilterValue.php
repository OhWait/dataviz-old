<?php

declare(strict_types=1);

namespace App\Domain\Datapool\ValueObject\Chart;

final readonly class FilterValue implements \Stringable
{
    public function __construct(private string $value)
    {
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
