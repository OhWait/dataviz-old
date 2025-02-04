<?php

declare(strict_types=1);

namespace App\Application\Dataviz\Query\Dataset;

use App\Domain\Enum\Dataset\OrderByEnum;
use App\Shared\Application\Query\AbstractPaginatedQuery;

final readonly class FindAllDatasetQuery extends AbstractPaginatedQuery
{
    /**
     * @param string[] $themes
     */
    public function __construct(
        public int $page,
        public int $itemsPerPage,
        public array $themes = [],
        public ?OrderByEnum $orderBy = null,
        public bool $withDataProvider = false,
    ) {
    }

    public function hasTheme(): bool
    {
        return count($this->themes) > 0;
    }
}
