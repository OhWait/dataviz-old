<?php

declare(strict_types=1);

namespace App\Application\Query\DataEntry;

use App\Domain\Model\DataEntry;
use App\Domain\Repository\DataEntryRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
final readonly class FindDataEntryQueryHandler
{
    public function __construct(
        private DataEntryRepositoryInterface $repository,
    ) {
    }

    public function __invoke(FindDataEntryQuery $query): ?DataEntry
    {
        return $this->repository->find($query->slug->value);
    }
}
