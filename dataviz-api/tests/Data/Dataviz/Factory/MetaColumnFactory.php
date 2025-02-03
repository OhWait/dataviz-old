<?php

declare(strict_types=1);

namespace App\Tests\Data\Dataviz\Factory;

use App\Domain\Dataviz\Enum\MetaColumn\DataTypeEnum;
use App\Domain\Dataviz\Model\MetaColumn;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnCharacterMaximumLength;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnColumnName;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnDataType;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnLabel;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnNullable;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

use function Zenstruck\Foundry\lazy;

/**
 * @extends PersistentProxyObjectFactory<MetaColumn>
 */
final class MetaColumnFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return MetaColumn::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function defaults(): array|callable
    {
        return [
            'columnName' => new MetaColumnColumnName(self::faker()->unique()->slug()),
            'nullable' => new MetaColumnNullable(self::faker()->boolean()),
            'dataType' => new MetaColumnDataType(self::faker()->randomElement(DataTypeEnum::class)->value),
            'characterMaximumLength' => new MetaColumnCharacterMaximumLength(self::faker()->numberBetween(1, 255)),
            'label' => new MetaColumnLabel(self::faker()->text(255)),
            'dataEntry' => lazy(fn () => DataEntryFactory::randomOrCreate()),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(DataEntry $dataEntry): void {})
        ;
    }
}
