<?php

declare(strict_types=1);

namespace App\Domain\Datapool\ValueObject\Municipality;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class MunicipalityTypecom
{
    #[ORM\Id]
    #[ORM\Column(name: 'typecom', length: 4)]
    public readonly string $value;

    public function __construct(string $value)
    {
        Assert::lengthBetween($value, 1, 4);

        $this->value = $value;
    }
}
