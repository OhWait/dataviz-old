<?php

declare(strict_types=1);

namespace App\Domain\Dataviz\ValueObject\DataEntry;

use App\Shared\Domain\ValueObject\AggregateCreatedAt;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class DataEntryCreatedAt
{
    use AggregateCreatedAt;
}
