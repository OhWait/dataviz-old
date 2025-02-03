<?php

declare(strict_types=1);

namespace App\Application\Command\DataEntry;

use App\Domain\Model\DataEntry;
use App\Domain\Repository\DataEntryRepositoryInterface;
use App\Domain\Repository\DatasetRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
final readonly class CreateDataEntryCommandHandler
{
    public function __construct(
        private readonly DatasetRepositoryInterface $datasetRepository,
        private readonly DataEntryRepositoryInterface $dataEntryRepository,
    ) {
    }

    public function __invoke(CreateDataEntryCommand $command): DataEntry
    {
        $dataset = $this->datasetRepository->find($command->dataset->value);

        $dataEntry = new DataEntry(
            slug: $command->slug,
            title: $command->title,
            schemaName: $command->schemaName,
            tableName: $command->tableName,
            dataset: $dataset,
        );

        $this->dataEntryRepository->save($dataEntry);

        return $this->dataEntryRepository->find($command->slug);
    }
}
