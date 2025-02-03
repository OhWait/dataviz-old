<?php

declare(strict_types=1);

namespace App\Application\Datapool\Query;

use App\Domain\Datapool\Model\AdministrativeDivision\Piic;
use App\Domain\Datapool\Repository\PiicRepositoryInterface;
use App\Shared\Domain\Repository\PaginatorInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
final readonly class FindAllPiicQueryHandler
{
    public function __construct(
        private PiicRepositoryInterface $repository,
    ) {
    }

    /**
     * @return PaginatorInterface<Piic>
     */
    public function __invoke(FindAllPiicQuery $query): PaginatorInterface
    {
        return $this->repository->paginate($query);
    }
}
