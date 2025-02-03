<?php

declare(strict_types=1);

namespace App\Domain\Dataviz\ValueObject\DataEntry;

use App\Shared\Domain\ValueObject\AggregateUpdatedAt;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class DataEntryUpdatedAt
{
    use AggregateUpdatedAt;
}
