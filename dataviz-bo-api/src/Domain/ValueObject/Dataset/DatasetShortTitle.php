<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\Dataset;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class DatasetShortTitle
{
    #[ORM\Column(name: 'short_title', length: 255, nullable: true)]
    public readonly ?string $value;

    public function __construct(?string $value = null)
    {
        Assert::nullOrLengthBetween($value, 1, 255);

        $this->value = $value;
    }
}
