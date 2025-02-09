<?php

declare(strict_types=1);

namespace App\Tests\Data\Dataviz\Factory;

use App\Domain\Dataviz\Model\MetaRow;
use App\Domain\Dataviz\ValueObject\MetaRow\MetaRowLabel;
use App\Domain\Dataviz\ValueObject\MetaRow\MetaRowValue;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

use function Zenstruck\Foundry\lazy;

/**
 * @extends PersistentProxyObjectFactory<MetaRow>
 */
final class MetaRowFactory extends PersistentProxyObjectFactory
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
        return MetaRow::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function defaults(): array|callable
    {
        return [
            'label' => new MetaRowLabel(self::faker()->unique()->slug(2)),
            'value' => new MetaRowValue(self::faker()->unique()->slug(1)),
            'metaColumn' => MetaColumnFactory::new(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Post $post) {})
        ;
    }
}
