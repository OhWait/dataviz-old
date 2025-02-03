<?php

declare(strict_types=1);

namespace App\Infrastructure\Datapool\Repository;

use App\Domain\Datapool\Model\AdministrativeDivision\Municipality;
use App\Domain\Datapool\Repository\MunicipalityRepositoryInterface;
use App\Shared\Infrastructure\Doctrine\DoctrineRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends DoctrineRepository<Municipality>
 */
class MunicipalityRepository extends DoctrineRepository implements MunicipalityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Municipality::class);
    }
}
