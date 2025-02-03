<?php

declare(strict_types=1);

namespace App\Domain\Datapool\ValueObject\Municipality;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class MunicipalityCodgeo
{
    #[ORM\Id]
    #[ORM\Column(name: 'codgeo', length: 5)]
    public readonly string $value;

    public function __construct(string $value)
    {
        Assert::maxLength($value, 5);

        $this->value = $value;
    }
}
