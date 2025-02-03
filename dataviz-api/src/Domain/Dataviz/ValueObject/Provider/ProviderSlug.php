<?php

declare(strict_types=1);

namespace App\Domain\Dataviz\ValueObject\Provider;

use App\Shared\Domain\ValueObject\AggregateRootSlug;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class ProviderSlug implements \Stringable
{
    use AggregateRootSlug;
}
