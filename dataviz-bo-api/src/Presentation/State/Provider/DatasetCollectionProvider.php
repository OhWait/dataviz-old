<?php

declare(strict_types=1);

namespace App\Presentation\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\Pagination\PartialPaginatorInterface;
use App\Application\Query\Dataset\FindAllDatasetQuery;
use App\Presentation\Resource\DatasetResource;
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
        $message = new FindAllDatasetQuery(
            page: $this->pagination->getPage($context),
            itemsPerPage: $this->pagination->getLimit($operation, $context),
        );

        $collection = $this->dispatch($message);

        return $this->paginate(
            DatasetResource::class,
            'fromArrayDomain',
            $collection,
        );
    }
}
