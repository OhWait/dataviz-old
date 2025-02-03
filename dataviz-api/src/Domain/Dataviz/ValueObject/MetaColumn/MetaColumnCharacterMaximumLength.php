<?php

declare(strict_types=1);

namespace App\Domain\Dataviz\ValueObject\MetaColumn;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class MetaColumnCharacterMaximumLength
{
    #[ORM\Column(name: 'character_maximum_length', type: Types::INTEGER, nullable: true)]
    public readonly ?int $value;

    public function __construct(?int $value = null)
    {
        $this->value = $value;
    }
}
