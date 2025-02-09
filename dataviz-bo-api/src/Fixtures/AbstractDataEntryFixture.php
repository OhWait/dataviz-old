<?php

declare(strict_types=1);

namespace App\Fixtures;

use App\Entity\DataEntry;
use App\Entity\Dataset;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

abstract class AbstractDataEntryFixture extends Fixture implements DependentFixtureInterface
{
    abstract public function getDependencies(): array;

    public function load(ObjectManager $em): void
    {
        foreach ($this->getDataEntries() as $dataEntry) {
            [$slug, $title, $schemaName, $tableName, $dataset] = $dataEntry;
            $model = new DataEntry(
                slug: $slug,
                title: $title,
                schemaName: $schemaName,
                tableName: $tableName,
                dataset: $this->getReference($dataset, Dataset::class),
            );
            $this->addReference("{$schemaName}.{$tableName}", $model);
            $em->persist($model);
        }

        $em->flush();
    }

    abstract protected function getDataEntries(): \Generator;
}
