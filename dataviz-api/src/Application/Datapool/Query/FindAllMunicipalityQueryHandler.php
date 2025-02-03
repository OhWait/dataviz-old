<?php

declare(strict_types=1);

namespace App\Application\Datapool\Query;

use App\Domain\Datapool\Model\AdministrativeDivision\Municipality;
use App\Domain\Datapool\Repository\MunicipalityRepositoryInterface;
use App\Shared\Domain\Repository\PaginatorInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
final readonly class FindAllMunicipalityQueryHandler
{
    public function __construct(
        private MunicipalityRepositoryInterface $repository,
    ) {
    }

    /**
     * @return PaginatorInterface<Municipality>
     */
    public function __invoke(FindAllMunicipalityQuery $query): PaginatorInterface
    {
        return $this->repository->paginate($query);
    }
}
