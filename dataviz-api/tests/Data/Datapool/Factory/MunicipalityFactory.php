<?php

declare(strict_types=1);

namespace App\Tests\Data\Datapool\Factory;

use App\Domain\Datapool\Model\AdministrativeDivision\Municipality;
use App\Domain\Datapool\ValueObject\Municipality\MunicipalityCodgeo;
use App\Domain\Datapool\ValueObject\Municipality\MunicipalityLabel;
use App\Domain\Datapool\ValueObject\Municipality\MunicipalityTypecom;
use App\Domain\Datapool\ValueObject\Municipality\MunicipalityYear;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Municipality>
 */
final class MunicipalityFactory extends PersistentProxyObjectFactory
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
        return Municipality::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'year' => new MunicipalityYear((int) self::faker()->year()),
            'typecom' => self::faker()->regexify('[A-Z]{3}'),
            'codgeo' => new MunicipalityCodgeo(self::faker()->regexify('\d{5}')),
            'label' => new MunicipalityLabel(self::faker()->word()),
            'reg' => self::faker()->regexify('[0-9]{2}'),
            'dep' => self::faker()->regexify('[0-9]{2}'),
            'ctcd' => self::faker()->regexify('[0-9]{2}[A-Z]{1}'),
            'arr' => self::faker()->regexify('[0-9]{3}'),
            'tncc' => self::faker()->regexify('[0-9]{1}'),
            'ncc' => self::faker()->word(),
            'nccenr' => self::faker()->word(),
            'can' => self::faker()->regexify('[0-9]{4}'),
            'comparent' => self::faker()->regexify('[0-9]{5}'),
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
