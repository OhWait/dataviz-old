<?php

declare(strict_types=1);

namespace App\Tests\Data\Dataviz\Factory;

use App\Domain\Dataviz\Model\Dataset;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetDataCreatedAt;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetDataProvider;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetDataUpdatedAt;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetDescription;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetGranularity;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetLanguage;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetPerimeter;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetSecurity;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetShortTitle;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetSlug;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetTitle;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetUpdateFrequency;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetUpdatePeriod;
use App\Presentation\Dataviz\Resource\DatasetResource;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

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
            'slug' => new DatasetSlug(self::faker()->unique()->slug()),
            'title' => new DatasetTitle(self::faker()->title()),
            'shortTitle' => new DatasetShortTitle(self::faker()->boolean() ? self::faker()->title() : null),
            'description' => new DatasetDescription(self::faker()->boolean() ? self::faker()->sentence() : null),
            'perimeter' => new DatasetPerimeter(self::faker()->sentence(2)),
            'granularity' => new DatasetGranularity(self::faker()->randomElement(DatasetResource::GRANULARITY)),
            'updateFrequency' => new DatasetUpdateFrequency(self::faker()->boolean() ? self::faker()->randomElement(DatasetResource::FREQUENCY) : null),
            'updatePeriod' => new DatasetUpdatePeriod(self::faker()->boolean() ? self::faker()->sentence() : null),
            'security' => new DatasetSecurity(self::faker()->randomElement(DatasetResource::SECURITY)),
            'language' => new DatasetLanguage(self::faker()->boolean() ? self::faker()->randomElement(DatasetResource::LANGUAGE) : null),
            'dataCreatedAt' => new DatasetDataCreatedAt(self::faker()->boolean() ? self::faker()->dateTime() : null),
            'dataUpdatedAt' => new DatasetDataUpdatedAt(self::faker()->boolean() ? self::faker()->dateTime() : null),
            'dataProvider' => new DatasetDataProvider(self::faker()->boolean() ? self::faker()->randomElement(DatasetResource::DATA_PROVIDER) : null),
            'provider' => ProviderFactory::new(),
            'themes' => ThemeFactory::createMany(self::faker()->numberBetween(0, 3)),
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
