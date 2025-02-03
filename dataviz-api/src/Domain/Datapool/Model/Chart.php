<?php

declare(strict_types=1);

namespace App\Domain\Datapool\Model;

use App\Domain\Datapool\Model\Chart\Query;
use App\Domain\Datapool\Model\Chart\Serie;

class Chart
{
    /**
     * @param Serie[] $series
     */
    public function __construct(
        private Query $query,
        private array $series,
    ) {
    }

    /**
     * @return Serie[] $series
     */
    public function series(): array
    {
        return $this->series;
    }

    public function query(): Query
    {
        return $this->query;
    }
}
