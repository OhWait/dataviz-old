<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\Provider;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class ProviderImage
{
    #[ORM\Column(name: 'image', length: 255, nullable: true)]
    public ?string $value = null;

    public function __construct(?string $value = null)
    {
        $this->value = $value;
    }

    public function isEmpty(): bool
    {
        return null !== $this->value;
    }
}
