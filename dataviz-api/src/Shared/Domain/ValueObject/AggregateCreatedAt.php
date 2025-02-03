<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait AggregateCreatedAt
{
    #[ORM\Column(name: 'created_at', type: Types::DATETIME_MUTABLE)]
    public readonly \DateTimeInterface $value;

    public function __construct()
    {
        $this->value = new \DateTime();
    }
}
