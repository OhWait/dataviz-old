<?php

declare(strict_types=1);

namespace App\Presentation\State\Processor\DataEntry;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\ParameterValidator\Exception\ValidationException;
use App\Application\Command\DataEntry\UpdateDataEntryCommand;
use App\Domain\Model\DataEntry;
use App\Domain\ValueObject\DataEntry\DataEntrySchemaName;
use App\Domain\ValueObject\DataEntry\DataEntrySlug;
use App\Domain\ValueObject\DataEntry\DataEntryTableName;
use App\Domain\ValueObject\DataEntry\DataEntryTitle;
use App\Presentation\Resource\DataEntryResource;
use App\Shared\Presentation\AbstractProcessor;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @extends AbstractProcessor<DataEntryResource, DataEntryResource>
 */
final class DataEntryUpdateProcessor extends AbstractProcessor
{
    public function __construct(
        protected MessageBusInterface $bus,
    ) {
    }

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): DataEntryResource {
        try {
            $model = $this->updateCommand($data);

            return DataEntryResource::fromDomain($model);
        } catch (\Exception $e) {
            throw new ValidationException([], $e->getPrevious()->getMessage());
        }
    }

    private function updateCommand(DataEntryResource $data): DataEntry
    {
        $command = new UpdateDataEntryCommand(
            slug: new DataEntrySlug($data->slug),
            title: new DataEntryTitle($data->title),
            schemaName: new DataEntrySchemaName($data->schemaName),
            tableName: new DataEntryTableName($data->tableName),
        );

        return $this->dispatch($command);
    }
}
