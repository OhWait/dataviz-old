<?php

declare(strict_types=1);

namespace App\Tests\Data\Datapool\Factory;

use App\Domain\Datapool\Model\AdministrativeDivision\Department;
use App\Domain\Datapool\ValueObject\Department\DepartmentCode;
use App\Domain\Datapool\ValueObject\Department\DepartmentLabel;
use App\Domain\Datapool\ValueObject\Department\DepartmentYear;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Department>
 */
final class DepartmentFactory extends PersistentProxyObjectFactory
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
        return Department::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'year' => new DepartmentYear((int) self::faker()->year()),
            'code' => new DepartmentCode(self::faker()->regexify('[A-Za-z]{3}')),
            'label' => new DepartmentLabel(self::faker()->word()),
            'reg' => self::faker()->regexify('[0-9]{2}'),
            'cheflieu' => self::faker()->regexify('[A-Za-z]{5}'),
            'tncc' => self::faker()->regexify('[0-9]{1}'),
            'ncc' => self::faker()->word(),
            'nccenr' => self::faker()->word(),
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
