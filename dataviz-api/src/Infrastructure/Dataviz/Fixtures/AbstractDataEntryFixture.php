<?php

declare(strict_types=1);

namespace App\Infrastructure\Dataviz\Fixtures;

use App\Domain\Dataviz\Model\DataEntry;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntrySchemaName;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntrySlug;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntryTableName;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntryTitle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

abstract class AbstractDataEntryFixture extends Fixture implements DependentFixtureInterface
{
    abstract public function getDependencies();

    public function load(ObjectManager $em): void
    {
        foreach ($this->getDataEntries() as $dataEntry) {
            list($slug, $title, $schemaName, $tableName, $dataset) = $dataEntry;
            $model = new DataEntry(
                slug: new DataEntrySlug($slug),
                title: new DataEntryTitle($title),
                schemaName: new DataEntrySchemaName($schemaName),
                tableName: new DataEntryTableName($tableName),
                dataset: $this->getReference($dataset),
            );
            $this->addReference("{$schemaName}.{$tableName}", $model);
            $em->persist($model);
        }

        $em->flush();
    }

    abstract protected function getDataEntries(): \Generator;
}
