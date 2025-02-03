<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\Provider;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class ProviderDescription
{
    #[ORM\Column(name: 'description', type: Types::TEXT, nullable: true)]
    public readonly ?string $value;

    public function __construct(?string $value = null)
    {
        Assert::nullOrMinLength($value, 1);

        $this->value = $value;
    }
}
