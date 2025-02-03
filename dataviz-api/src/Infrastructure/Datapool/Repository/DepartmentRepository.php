<?php

declare(strict_types=1);

namespace App\Infrastructure\Datapool\Repository;

use App\Domain\Datapool\Model\AdministrativeDivision\Department;
use App\Domain\Datapool\Repository\DepartmentRepositoryInterface;
use App\Shared\Infrastructure\Doctrine\DoctrineRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends DoctrineRepository<Department>
 */
class DepartmentRepository extends DoctrineRepository implements DepartmentRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Department::class);
    }
}
