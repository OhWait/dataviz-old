<?php

declare(strict_types=1);

namespace App\Tests\Data\Factory;

use App\Entity\Provider;
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
            'slug' => self::faker()->unique()->slug(),
            'name' => self::faker()->unique()->slug(1),
            'acronym' => self::faker()->boolean() ? self::faker()->title() : null,
            'description' => self::faker()->boolean() ? self::faker()->sentence() : null,
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
