<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\MetaColumn;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class MetaColumnNullable
{
    #[ORM\Column(name: 'nullable', type: Types::BOOLEAN)]
    public readonly bool $value;

    public function __construct(bool $value)
    {
        $this->value = $value;
    }
}
