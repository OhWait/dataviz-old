<?php

declare(strict_types=1);

namespace App\Application\Dataviz\Query\Dataset;

use App\Domain\Dataviz\Model\Dataset;
use App\Domain\Dataviz\Repository\DatasetRepositoryInterface;
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
