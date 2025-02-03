<?php

declare(strict_types=1);

namespace App\Domain\Datapool\ValueObject\Piic;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class PiicYear
{
    #[ORM\Id]
    #[ORM\Column(name: 'annee', type: Types::INTEGER)]
    public readonly int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }
}
