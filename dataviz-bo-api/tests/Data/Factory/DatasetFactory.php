<?php

declare(strict_types=1);

namespace App\Tests\Data\Factory;

use App\Entity\Dataset;
use App\Enum\Dataset\DataProviderEnum;
use App\Enum\Dataset\FrequencyEnum;
use App\Enum\Dataset\GranularityEnum;
use App\Enum\Dataset\LanguageEnum;
use App\Enum\Dataset\SecurityEnum;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

use function Zenstruck\Foundry\lazy;

/**
 * @extends PersistentProxyObjectFactory<Dataset>
 */
final class DatasetFactory extends PersistentProxyObjectFactory
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
        return Dataset::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'slug' => self::faker()->unique()->slug(),
            'title' => self::faker()->title(),
            'shortTitle' => self::faker()->boolean() ? self::faker()->title() : null,
            'description' => self::faker()->boolean() ? self::faker()->sentence() : null,
            'perimeter' => self::faker()->sentence(2),
            'granularity' => self::faker()->randomElement(GranularityEnum::class)->value,
            'updateFrequency' => self::faker()->boolean() ? self::faker()->randomElement(FrequencyEnum::class)->value : null,
            'updatePeriod' => self::faker()->boolean() ? self::faker()->sentence() : null,
            'security' => self::faker()->randomElement(SecurityEnum::getValues()),
            'language' => self::faker()->boolean() ? self::faker()->randomElement(LanguageEnum::class)->value : null,
            'dataCreatedAt' => self::faker()->boolean() ? self::faker()->dateTime() : null,
            'dataUpdatedAt' => self::faker()->boolean() ? self::faker()->dateTime() : null,
            'dataProvider' => self::faker()->boolean() ? self::faker()->randomElement(DataProviderEnum::class)->value : null,
            'provider' => ProviderFactory::new(),
            'themes' => ThemeFactory::createMany(self::faker()->numberBetween(0, 3)),
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'updatedAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Dataset $dataset): void {})
        ;
    }
}
