<?php

declare(strict_types=1);

namespace App\Domain\Dataviz\ValueObject\Provider;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class ProviderAcronym
{
    #[ORM\Column(name: 'acronym', length: 255, nullable: true)]
    public readonly ?string $value;

    public function __construct(?string $value = null)
    {
        Assert::nullOrLengthBetween($value, 1, 255);

        $this->value = $value;
    }
}
