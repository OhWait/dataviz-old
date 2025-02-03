<?php

declare(strict_types=1);

namespace App\Infrastructure\Fixtures;

use App\Domain\Model\DataEntry;
use App\Domain\ValueObject\DataEntry\DataEntrySchemaName;
use App\Domain\ValueObject\DataEntry\DataEntrySlug;
use App\Domain\ValueObject\DataEntry\DataEntryTableName;
use App\Domain\ValueObject\DataEntry\DataEntryTitle;
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
