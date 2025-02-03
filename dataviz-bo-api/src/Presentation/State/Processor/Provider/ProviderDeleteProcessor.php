<?php

declare(strict_types=1);

namespace App\Presentation\State\Processor\Provider;

use ApiPlatform\Metadata\Operation;
use App\Application\Command\Provider\DeleteProviderCommand;
use App\Domain\ValueObject\Provider\ProviderSlug;
use App\Presentation\Resource\ProviderResource;
use App\Shared\Presentation\AbstractProcessor;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @extends AbstractProcessor<ProviderResource, void>
 */
final class ProviderDeleteProcessor extends AbstractProcessor
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
        $message = new DeleteProviderCommand(
            new ProviderSlug($data->slug),
        );

        $this->dispatch($message);
    }
}
