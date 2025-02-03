<?php

declare(strict_types=1);

namespace App\Application\Query\Provider;

final readonly class FindProviderQuery
{
    public function __construct(
        public string $slug,
    ) {
    }
}
