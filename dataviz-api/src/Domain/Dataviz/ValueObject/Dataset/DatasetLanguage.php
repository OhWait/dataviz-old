<?php

declare(strict_types=1);

namespace App\Domain\Dataviz\ValueObject\Dataset;

use App\Domain\Dataviz\Enum\Dataset\LanguageEnum;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class DatasetLanguage
{
    #[ORM\Column(name: 'language', length: 255, nullable: true)]
    public readonly ?LanguageEnum $value;

    public function __construct(?string $value = null)
    {
        if (null !== $value) {
            Assert::notNull(LanguageEnum::tryFrom($value));

            $this->value = LanguageEnum::from($value);
        } else {
            $this->value = null;
        }
    }

    public function value(): ?string
    {
        return $this->value?->value;
    }
}
