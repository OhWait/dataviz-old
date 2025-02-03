<?php

declare(strict_types=1);

namespace App\Presentation\State\Provider;

use ApiPlatform\Metadata\Operation;
use App\Application\Query\Dataset\FindDatasetQuery;
use App\Domain\ValueObject\Dataset\DatasetSlug;
use App\Presentation\Resource\DatasetResource;
use App\Shared\Presentation\AbstractProvider;
use Symfony\Component\Messenger\MessageBusInterface;

final class DatasetItemProvider extends AbstractProvider
{
    public function __construct(
        protected MessageBusInterface $bus,
    ) {
    }

    public function provide(
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): ?DatasetResource {
        $message = new FindDatasetQuery(
            new DatasetSlug($uriVariables['slug']),
        );

        $model = $this->dispatch($message);

        return null !== $model ? DatasetResource::fromDomain($model) : null;
    }
}
