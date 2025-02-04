<?php

declare(strict_types=1);

namespace App\Presentation\Dataviz\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\Pagination\PartialPaginatorInterface;
use App\Application\Dataviz\Query\Dataset\FindAllDatasetQuery;
use App\Presentation\Dataviz\Resource\DatasetResource;
use App\Shared\Presentation\AbstractProvider;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @extends parent<DatasetResource>
 */
final class DatasetCollectionProvider extends AbstractProvider
{
    public function __construct(
        protected MessageBusInterface $bus,
        private readonly Pagination $pagination,
    ) {
    }

    public function provide(
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): PartialPaginatorInterface {
        $query = $context['filters'] ?? [];
        $themes = isset($query['themes']) ? $query['themes'] : [];

        $message = new FindAllDatasetQuery(
            page: $this->pagination->getPage($context),
            itemsPerPage: $this->pagination->getLimit($operation, $context),
            themes: \is_array($themes) ? $themes : [$themes],
        );

        $collection = $this->dispatch($message);

        return $this->paginate(
            DatasetResource::class,
            'fromArrayDomain',
            $collection,
        );
    }
}
