<?php

declare(strict_types=1);

namespace App\Tests\Data\Datapool\Factory;

use App\Domain\Datapool\Model\AdministrativeDivision\Piic;
use App\Domain\Datapool\ValueObject\Piic\PiicCode;
use App\Domain\Datapool\ValueObject\Piic\PiicLabel;
use App\Domain\Datapool\ValueObject\Piic\PiicNature;
use App\Domain\Datapool\ValueObject\Piic\PiicYear;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Piic>
 */
final class PiicFactory extends PersistentProxyObjectFactory
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
        return Piic::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'year' => new PiicYear((int) self::faker()->year()),
            'code' => new PiicCode(self::faker()->regexify('[A-Za-z]{15}')),
            'label' => new PiicLabel(self::faker()->word()),
            'nature' => new PiicNature(self::faker()->word()),
            'nbMunicipality' => self::faker()->randomNumber(2),
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
