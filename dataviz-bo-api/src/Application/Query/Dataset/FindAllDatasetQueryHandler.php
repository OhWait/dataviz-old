<?php

declare(strict_types=1);

namespace App\Application\Query\Dataset;

use App\Domain\Model\Dataset;
use App\Domain\Repository\DatasetRepositoryInterface;
use App\Shared\Domain\Repository\PaginatorInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
final readonly class FindAllDatasetQueryHandler
{
    public function __construct(
        private DatasetRepositoryInterface $repository,
    ) {
    }

    /**
     * @return PaginatorInterface<Dataset>
     */
    public function __invoke(FindAllDatasetQuery $query): PaginatorInterface
    {
        return $this->repository->paginate($query);
    }
}
