<?php

declare(strict_types=1);

namespace App\Domain\Datapool\ValueObject\Piic;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class PiicCode
{
    #[ORM\Id]
    #[ORM\Column(name: 'codeepci', length: 15)]
    public readonly string $value;

    public function __construct(string $value)
    {
        Assert::maxLength($value, 15);

        $this->value = $value;
    }
}
