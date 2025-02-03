<?php

declare(strict_types=1);

namespace App\Domain\Dataviz\ValueObject\DataEntry;

use App\Shared\Domain\ValueObject\AggregateRootSlug;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class DataEntrySlug implements \Stringable
{
    use AggregateRootSlug;

    public function equals(DataEntrySlug $slug): bool
    {
        return $this->value === $slug->value;
    }
}
