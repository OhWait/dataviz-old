<?php

declare(strict_types=1);

namespace App\Application\Command\Provider;

use App\Domain\ValueObject\Provider\ProviderAcronym;
use App\Domain\ValueObject\Provider\ProviderDescription;
use App\Domain\ValueObject\Provider\ProviderName;
use App\Domain\ValueObject\Provider\ProviderSlug;

final readonly class CreateProviderCommand
{
    public function __construct(
        public ProviderSlug $slug,
        public ProviderName $name,
        public ProviderAcronym $acronym,
        public ProviderDescription $description,
    ) {
    }
}
