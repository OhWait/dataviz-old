<?php

declare(strict_types=1);

namespace App\Application\Datapool\Query;

use App\Domain\Datapool\Model\AdministrativeDivision\Department;
use App\Domain\Datapool\Repository\DepartmentRepositoryInterface;
use App\Shared\Domain\Repository\PaginatorInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
final readonly class FindAllDepartmentQueryHandler
{
    public function __construct(
        private DepartmentRepositoryInterface $repository,
    ) {
    }

    /**
     * @return PaginatorInterface<Department>
     */
    public function __invoke(FindAllDepartmentQuery $query): PaginatorInterface
    {
        return $this->repository->paginate($query);
    }
}
