<?php

declare(strict_types=1);

namespace App\Domain\Dataviz\ValueObject\Dataset;

use App\Shared\Domain\ValueObject\AggregateCreatedAt;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class DatasetCreatedAt
{
    use AggregateCreatedAt;
}
