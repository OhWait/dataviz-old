<?php

declare(strict_types=1);

namespace App\Presentation\Dataviz\State\Provider;

use ApiPlatform\Metadata\Operation;
use App\Application\Dataviz\Query\Provider\FindProviderQuery;
use App\Domain\Dataviz\ValueObject\Provider\ProviderSlug;
use App\Presentation\Dataviz\Resource\ProviderResource;
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
        $message = new FindProviderQuery(
            new ProviderSlug($uriVariables['slug']),
        );

        $model = $this->dispatch($message);

        return null !== $model ? ProviderResource::fromDomain($model) : null;
    }
}
