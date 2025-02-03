<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\Dataset;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class DatasetDataCreatedAt
{
    #[ORM\Column(name: 'data_created_at', type: Types::DATE_MUTABLE, nullable: true)]
    public readonly ?\DateTimeInterface $value;

    public function __construct(?\DateTimeInterface $value = null)
    {
        $this->value = $value;
    }
}
