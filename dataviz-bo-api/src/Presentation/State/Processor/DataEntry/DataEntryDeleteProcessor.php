<?php

declare(strict_types=1);

namespace App\Presentation\State\Processor\DataEntry;

use ApiPlatform\Metadata\Operation;
use App\Application\Command\DataEntry\DeleteDataEntryCommand;
use App\Domain\ValueObject\DataEntry\DataEntrySlug;
use App\Presentation\Resource\DataEntryResource;
use App\Shared\Presentation\AbstractProcessor;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @extends AbstractProcessor<DataEntryResource, void>
 */
final class DataEntryDeleteProcessor extends AbstractProcessor
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
    ): void {
        $message = new DeleteDataEntryCommand(
            new DataEntrySlug($data->slug),
        );

        $this->bus->dispatch($message);
    }
}
