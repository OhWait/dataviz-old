<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\MetaColumn;

use App\Domain\Enum\MetaColumn\DataTypeEnum;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class MetaColumnDataType
{
    #[ORM\Column(name: 'data_type', length: 255)]
    public readonly DataTypeEnum $value;

    public function __construct(string $value)
    {
        Assert::notNull(DataTypeEnum::tryFrom($value));

        $this->value = DataTypeEnum::from($value);
    }

    public function value(): string
    {
        return $this->value->value;
    }
}
