<?php

declare(strict_types=1);

namespace App\Presentation\Dataviz\State\Provider;

use ApiPlatform\Metadata\Operation;
use App\Application\Dataviz\Query\Theme\FindThemeQuery;
use App\Domain\Dataviz\ValueObject\Theme\ThemeSlug;
use App\Presentation\Dataviz\Resource\ThemeResource;
use App\Shared\Presentation\AbstractProvider;
use Symfony\Component\Messenger\MessageBusInterface;

final class ThemeItemProvider extends AbstractProvider
{
    public function __construct(
        protected MessageBusInterface $bus,
    ) {
    }

    public function provide(
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): ?ThemeResource {
        $message = new FindThemeQuery(
            new ThemeSlug($uriVariables['slug']),
        );

        $model = $this->dispatch($message);

        return null !== $model ? ThemeResource::fromDomain($model) : null;
    }
}
