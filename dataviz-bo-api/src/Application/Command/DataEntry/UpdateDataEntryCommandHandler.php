<?php

declare(strict_types=1);

namespace App\Application\Command\DataEntry;

use App\Domain\Model\DataEntry;
use App\Domain\Repository\DataEntryRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
final readonly class UpdateDataEntryCommandHandler
{
    public function __construct(
        private readonly DataEntryRepositoryInterface $dataEntryRepository,
    ) {
    }

    public function __invoke(UpdateDataEntryCommand $command): DataEntry
    {
        $dataEntry = $this->dataEntryRepository->find($command->slug->value);

        $dataEntry->update(
            title: $command->title,
            schemaName: $command->schemaName,
            tableName: $command->tableName,
        );

        $this->dataEntryRepository->save($dataEntry);

        return $dataEntry;
    }
}
