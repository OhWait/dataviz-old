<?php

declare(strict_types=1);

namespace App\Domain\Dataviz\ValueObject\Dataset;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class DatasetDataUpdatedAt
{
    #[ORM\Column(name: 'data_updated_at', type: Types::DATE_MUTABLE, nullable: true)]
    #[ORM\OrderBy(['date' => 'ASC'])]
    public readonly ?\DateTimeInterface $value;

    public function __construct(?\DateTimeInterface $value = null)
    {
        $this->value = $value;
    }
}
