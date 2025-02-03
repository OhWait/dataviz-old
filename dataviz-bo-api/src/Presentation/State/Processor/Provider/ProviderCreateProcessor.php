<?php

declare(strict_types=1);

namespace App\Presentation\State\Processor\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\ParameterValidator\Exception\ValidationException;
use App\Application\Command\Provider\CreateProviderCommand;
use App\Domain\Model\Provider;
use App\Domain\ValueObject\Provider\ProviderAcronym;
use App\Domain\ValueObject\Provider\ProviderDescription;
use App\Domain\ValueObject\Provider\ProviderName;
use App\Domain\ValueObject\Provider\ProviderSlug;
use App\Presentation\Resource\ProviderResource;
use App\Shared\Presentation\AbstractProcessor;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @extends AbstractProcessor<ProviderResource, ProviderResource>
 */
final class ProviderCreateProcessor extends AbstractProcessor
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
    ): ProviderResource {
        try {
            $model = $this->createCommand($data);

            return ProviderResource::fromDomain($model);
        } catch (\Exception $e) {
            throw new ValidationException([], $e->getPrevious()->getMessage());
        }
    }

    private function createCommand(ProviderResource $data): Provider
    {
        $message = new CreateProviderCommand(
            slug: new ProviderSlug($data->slug),
            name: new ProviderName($data->name),
            acronym: new ProviderAcronym($data->acronym),
            description: new ProviderDescription($data->description),
        );

        return $this->dispatch($message);
    }
}
