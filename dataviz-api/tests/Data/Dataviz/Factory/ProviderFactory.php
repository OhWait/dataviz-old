<?php

declare(strict_types=1);

namespace App\Tests\Data\Dataviz\Factory;

use App\Domain\Dataviz\Model\Provider;
use App\Domain\Dataviz\ValueObject\Provider\ProviderAcronym;
use App\Domain\Dataviz\ValueObject\Provider\ProviderDescription;
use App\Domain\Dataviz\ValueObject\Provider\ProviderName;
use App\Domain\Dataviz\ValueObject\Provider\ProviderSlug;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Provider>
 */
final class ProviderFactory extends PersistentProxyObjectFactory
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
        return Provider::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'slug' => new ProviderSlug(self::faker()->unique()->slug()),
            'name' => new ProviderName(self::faker()->unique()->slug(1)),
            'acronym' => new ProviderAcronym(self::faker()->boolean() ? self::faker()->title() : null),
            'description' => new ProviderDescription(self::faker()->boolean() ? self::faker()->sentence() : null),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Provider $provider): void {})
        ;
    }
}
