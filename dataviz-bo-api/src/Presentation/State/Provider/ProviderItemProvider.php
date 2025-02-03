<?php

declare(strict_types=1);

namespace App\Presentation\State\Provider;

use ApiPlatform\Metadata\Operation;
use App\Application\Query\Provider\FindProviderQuery;
use App\Presentation\Resource\ProviderResource;
use App\Shared\Presentation\AbstractProvider;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @extends parent<ProviderResource>
 */
final class ProviderItemProvider extends AbstractProvider
{
    public function __construct(
        protected MessageBusInterface $bus,
    ) {
    }

    public function provide(
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): ?ProviderResource {
        $message = new FindProviderQuery($uriVariables['slug']);

        $model = $this->dispatch($message);

        return null !== $model ? ProviderResource::fromDomain($model) : null;
    }
}
