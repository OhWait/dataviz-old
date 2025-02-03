<?php

declare(strict_types=1);

namespace App\Domain\Dataviz\ValueObject\Provider;

use App\Shared\Domain\ValueObject\AggregateUpdatedAt;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class ProviderUpdatedAt
{
    use AggregateUpdatedAt;
}
