<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\MetaColumn;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class MetaColumnId
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id')]
    public int $value;
}
