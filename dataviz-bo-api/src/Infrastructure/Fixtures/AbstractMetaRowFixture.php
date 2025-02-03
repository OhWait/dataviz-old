<?php

declare(strict_types=1);

namespace App\Infrastructure\Fixtures;

use App\Domain\Model\MetaRow;
use App\Domain\ValueObject\MetaRow\MetaRowLabel;
use App\Domain\ValueObject\MetaRow\MetaRowValue;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

abstract class AbstractMetaRowFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $em): void
    {
        foreach ($this->getMeta() as $meta) {
            @list(
                $metaColumn,
                $value,
                $label,
            ) = $meta;

            $meta = new MetaRow(
                value: new MetaRowValue((string) $value),
                label: new MetaRowLabel((string) $label),
                metaColumn: $this->getReference($metaColumn),
            );

            $em->persist($meta);
        }

        $em->flush();
    }

    abstract protected function getMeta(): \Generator;
}
