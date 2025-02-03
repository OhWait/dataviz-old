<?php

declare(strict_types=1);

namespace App\Presentation\Dataviz\State\Provider;

use ApiPlatform\Metadata\Operation;
use App\Application\Dataviz\Query\DataEntry\FindDataEntryQuery;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntrySlug;
use App\Presentation\Dataviz\Resource\DataEntryResource;
use App\Shared\Presentation\AbstractProvider;
use Symfony\Component\Messenger\MessageBusInterface;

final class DataEntryItemProvider extends AbstractProvider
{
    public function __construct(
        protected MessageBusInterface $bus,
    ) {
    }

    public function provide(
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): ?DataEntryResource {
        $message = new FindDataEntryQuery(
            new DataEntrySlug($uriVariables['slug']),
        );

        $model = $this->dispatch($message);

        return null !== $model ? DataEntryResource::fromDomain($model) : null;
    }
}
