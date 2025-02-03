<?php

declare(strict_types=1);

namespace App\Tests\Data\Datapool\Story;

use App\Tests\Data\Datapool\DatapoolHelper;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BaseStory extends KernelTestCase
{
    public static function insertData(string $file): void
    {
        $registry = self::getContainer()->get(ManagerRegistry::class);
        $repository = new DatapoolHelper($registry);

        foreach (explode(';', file_get_contents(__DIR__."/../Script/{$file}")) as $sql) {
            if (!empty($sql)) {
                $repository->getConnection()->executeQuery($sql);
            }
        }
    }
}
