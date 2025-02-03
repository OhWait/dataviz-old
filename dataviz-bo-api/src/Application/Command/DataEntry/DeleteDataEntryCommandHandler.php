<?php

declare(strict_types=1);

namespace App\Application\Command\DataEntry;

use App\Domain\Repository\DataEntryRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
final readonly class DeleteDataEntryCommandHandler
{
    public function __construct(private DataEntryRepositoryInterface $repository)
    {
    }

    public function __invoke(DeleteDataEntryCommand $command): void
    {
        $dataset = $this->repository->find($command->slug->value);

        $this->repository->remove($dataset);
    }
}
