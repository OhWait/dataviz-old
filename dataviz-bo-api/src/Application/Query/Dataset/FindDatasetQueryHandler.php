<?php

declare(strict_types=1);

namespace App\Application\Query\Dataset;

use App\Domain\Model\Dataset;
use App\Domain\Repository\DatasetRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
final readonly class FindDatasetQueryHandler
{
    public function __construct(
        private DatasetRepositoryInterface $repository,
    ) {
    }

    public function __invoke(FindDatasetQuery $query): ?Dataset
    {
        return $this->repository->find($query->slug->value);
    }
}
