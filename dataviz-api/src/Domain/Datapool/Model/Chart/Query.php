<?php

declare(strict_types=1);

namespace App\Domain\Datapool\Model\Chart;

class Query
{
    /**
     * @param string[] $bindValues
     */
    public function __construct(
        private string $statement,
        private array $bindValues,
    ) {
    }

    public function statement(): string
    {
        return $this->statement;
    }

    /**
     * @return string[]
     */
    public function bindValues(): array
    {
        return $this->bindValues;
    }
}
