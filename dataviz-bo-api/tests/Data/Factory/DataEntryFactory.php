<?php

declare(strict_types=1);

namespace App\Tests\Data\Factory;

use App\Entity\DataEntry;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<DataEntry>
 */
final class DataEntryFactory extends PersistentProxyObjectFactory
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
        return DataEntry::class;
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
            'schemaName' => self::faker()->text(255),
            'tableName' => self::faker()->text(255),
            'dataset' => DatasetFactory::new(),
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
