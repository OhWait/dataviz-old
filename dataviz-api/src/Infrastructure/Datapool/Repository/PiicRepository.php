<?php

declare(strict_types=1);

namespace App\Infrastructure\Datapool\Repository;

use App\Domain\Datapool\Model\AdministrativeDivision\Piic;
use App\Domain\Datapool\Repository\PiicRepositoryInterface;
use App\Shared\Infrastructure\Doctrine\DoctrineRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends DoctrineRepository<Piic>
 */
class PiicRepository extends DoctrineRepository implements PiicRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Piic::class);
    }
}
