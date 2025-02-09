<?php

declare(strict_types=1);

namespace App\Fixtures;

use App\Entity\MetaColumn;
use App\Entity\MetaRow;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

abstract class AbstractMetaRowFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $em): void
    {
        foreach ($this->getMeta() as $meta) {
            [$metaColumn, $value, $label] = $meta;

            $meta = new MetaRow(
                value: (string) $value,
                label: (string) $label,
                metaColumn: $this->getReference($metaColumn, MetaColumn::class),
            );

            $em->persist($meta);
        }

        $em->flush();
    }

    abstract protected function getMeta(): \Generator;
}
