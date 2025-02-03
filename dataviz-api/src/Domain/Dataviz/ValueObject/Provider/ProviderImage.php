<?php

declare(strict_types=1);

namespace App\Domain\Dataviz\ValueObject\Provider;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class ProviderImage
{
    #[ORM\Column(name: 'image', length: 255, nullable: true)]
    public readonly ?string $value;

    public function __construct(?string $value = null)
    {
        Assert::lengthBetween($value, 0, 255);

        $this->value = $value;
    }
}
