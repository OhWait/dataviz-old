<?php

declare(strict_types=1);

namespace App\Fixtures;

use App\Entity\DataEntry;
use App\Entity\MetaColumn;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

abstract class AbstractMetaColumnFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $em): void
    {
        foreach ($this->getMeta() as $meta) {
            [
                $dataEntry,
                $columnName,
                $label,
                $nullable,
                $dataType,
                $characterMaximumLength,
            ] = $meta;

            $meta = new MetaColumn(
                columnName: $columnName,
                nullable: $nullable,
                dataType: $dataType,
                characterMaximumLength: $characterMaximumLength,
                label: $label,
                dataEntry: $this->getReference($dataEntry, DataEntry::class),
            );

            $this->addReference("{$dataEntry}.{$columnName}", $meta);
            $em->persist($meta);
        }

        $em->flush();
    }

    abstract protected function getMeta(): \Generator;
}
