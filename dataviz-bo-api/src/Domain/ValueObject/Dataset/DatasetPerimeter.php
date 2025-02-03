<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\Dataset;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class DatasetPerimeter
{
    #[ORM\Column(name: 'perimeter', type: Types::TEXT)]
    public readonly string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }
}
