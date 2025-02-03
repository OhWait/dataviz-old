<?php

declare(strict_types=1);

namespace App\Domain\Dataviz\ValueObject\Dataset;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class DatasetDescription
{
    #[ORM\Column(name: 'description', type: Types::TEXT, nullable: true)]
    public readonly ?string $value;

    public function __construct(?string $value = null)
    {
        $this->value = $value;
    }
}
