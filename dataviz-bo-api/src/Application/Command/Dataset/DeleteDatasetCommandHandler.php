<?php

declare(strict_types=1);

namespace App\Application\Command\Dataset;

use App\Domain\Repository\DatasetRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
final readonly class DeleteDatasetCommandHandler
{
    public function __construct(private DatasetRepositoryInterface $repository)
    {
    }

    public function __invoke(DeleteDatasetCommand $command): void
    {
        $dataset = $this->repository->find($command->slug->value);

        $this->repository->remove($dataset);
    }
}
