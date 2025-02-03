<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\DataEntry;

use App\Shared\Domain\ValueObject\AggregateRootSlug;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class DataEntrySlug implements \Stringable
{
    use AggregateRootSlug;
}
