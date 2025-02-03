<?php

declare(strict_types=1);

namespace App\Presentation\State\Processor\Dataset;

use ApiPlatform\Metadata\Operation;
use App\Application\Command\Dataset\DeleteDatasetCommand;
use App\Domain\ValueObject\Dataset\DatasetSlug;
use App\Presentation\Resource\DatasetResource;
use App\Shared\Presentation\AbstractProcessor;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @extends AbstractProcessor<DatasetResource, void>
 */
final class DatasetDeleteProcessor extends AbstractProcessor
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
        $message = new DeleteDatasetCommand(
            new DatasetSlug($data->slug),
        );

        $this->dispatch($message);
    }
}
