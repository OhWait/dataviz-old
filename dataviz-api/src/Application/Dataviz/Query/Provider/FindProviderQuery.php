<?php

declare(strict_types=1);

namespace App\Application\Dataviz\Query\Provider;

use App\Domain\Dataviz\ValueObject\Provider\ProviderSlug;

final readonly class FindProviderQuery
{
    public function __construct(
        public ProviderSlug $slug,
    ) {
    }
}
