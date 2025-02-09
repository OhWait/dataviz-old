<?php

declare(strict_types=1);

namespace App\Tests\Data\Factory;

use App\Entity\MetaColumn;
use App\Enum\MetaColumn\DataTypeEnum;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

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
            'columnName' => self::faker()->unique()->slug(),
            'nullable' => self::faker()->boolean(),
            'dataType' => self::faker()->randomElement(DataTypeEnum::class)->value,
            'characterMaximumLength' => self::faker()->numberBetween(1, 255),
            'label' => self::faker()->text(255),
            'dataEntry' => DataEntryFactory::new(),
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
