<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\Dataset;

use App\Shared\Domain\ValueObject\AggregateRootSlug;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class DatasetSlug implements \Stringable
{
    use AggregateRootSlug;
}
