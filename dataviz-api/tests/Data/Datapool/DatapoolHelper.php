<?php

declare(strict_types=1);

namespace App\Tests\Data\Datapool;

use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ManagerRegistry;

class DatapoolHelper
{
    public const CONNECTION = 'pool';

    public function __construct(private ManagerRegistry $em)
    {
    }

    public function getConnection(): Connection
    {
        return $this->em->getConnection(self::CONNECTION);
    }
}
