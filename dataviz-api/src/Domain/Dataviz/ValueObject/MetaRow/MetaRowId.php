<?php

declare(strict_types=1);

namespace App\Domain\Dataviz\ValueObject\MetaRow;

use App\Shared\Domain\ValueObject\AggreagateUuid;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class MetaRowId
{
    use AggreagateUuid;
}
