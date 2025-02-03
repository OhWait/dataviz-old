<?php

declare(strict_types=1);

namespace App\Application\Dataviz\Query\DataEntry;

use App\Domain\Dataviz\Model\DataEntry;
use App\Domain\Dataviz\Repository\DataEntryRepositoryInterface;
use App\Shared\Domain\Repository\PaginatorInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
final readonly class FindAllDataEntryQueryHandler
{
    public function __construct(
        private DataEntryRepositoryInterface $repository,
    ) {
    }

    /**
     * @return PaginatorInterface<DataEntry>
     */
    public function __invoke(FindAllDataEntryQuery $query): PaginatorInterface
    {
        return $this->repository->paginate($query);
    }
}
