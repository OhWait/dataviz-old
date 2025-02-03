<?php

declare(strict_types=1);

namespace App\Application\Datapool\Query;

use App\Domain\Dataviz\Repository\DataEntryRepositoryInterface;
use App\Infrastructure\Datapool\Repository\DatapoolRepository;
use App\Shared\Domain\Repository\PaginatorInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
final readonly class FindPaginatedDataQueryHandler
{
    public function __construct(
        private DatapoolRepository $repository,
        private DataEntryRepositoryInterface $dataEntryRepository,
    ) {
    }

    /**
     * @return PaginatorInterface<object>
     */
    public function __invoke(FindPaginatedDataQuery $query): PaginatorInterface
    {
        $dataEntry = $this->dataEntryRepository->find($query->slug);

        return $this->repository->paginate(
            $query,
            $dataEntry,
            false,
        );
    }
}
