<?php

declare(strict_types=1);

namespace App\Infrastructure\Dataviz\Fixtures;

use App\Domain\Dataviz\Model\MetaColumn;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnCharacterMaximumLength;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnColumnName;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnDataType;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnLabel;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnNullable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

abstract class AbstractMetaColumnFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $em): void
    {
        foreach ($this->getMeta() as $meta) {
            @list(
                $dataEntry,
                $columnName,
                $label,
                $nullable,
                $dataType,
                $characterMaximumLength,
            ) = $meta;

            $meta = new MetaColumn(
                columnName: new MetaColumnColumnName($columnName),
                nullable: new MetaColumnNullable($nullable),
                dataType: new MetaColumnDataType($dataType),
                characterMaximumLength: new MetaColumnCharacterMaximumLength($characterMaximumLength),
                label: new MetaColumnLabel($label),
                dataEntry: $this->getReference($dataEntry),
            );

            $this->addReference("{$dataEntry}.{$columnName}", $meta);
            $em->persist($meta);
        }

        $em->flush();
    }

    abstract protected function getMeta(): \Generator;
}
