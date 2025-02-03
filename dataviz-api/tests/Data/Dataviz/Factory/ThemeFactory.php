<?php

declare(strict_types=1);

namespace App\Tests\Data\Dataviz\Factory;

use App\Domain\Dataviz\Model\Theme;
use App\Domain\Dataviz\ValueObject\Theme\ThemeSlug;
use App\Domain\Dataviz\ValueObject\Theme\ThemeTitle;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Theme>
 */
final class ThemeFactory extends PersistentProxyObjectFactory
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
        return Theme::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'slug' => new ThemeSlug(self::faker()->unique()->slug()),
            'title' => new ThemeTitle(self::faker()->title()),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Theme $theme): void {})
        ;
    }
}
