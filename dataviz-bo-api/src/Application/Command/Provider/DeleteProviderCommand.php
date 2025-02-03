<?php

declare(strict_types=1);

namespace App\Application\Command\Provider;

use App\Domain\ValueObject\Provider\ProviderSlug;

final readonly class DeleteProviderCommand
{
    public function __construct(
        public ProviderSlug $slug,
    ) {
    }
}
