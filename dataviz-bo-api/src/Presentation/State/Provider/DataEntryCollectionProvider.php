<?php

declare(strict_types=1);

namespace App\Presentation\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\Pagination\PartialPaginatorInterface;
use App\Application\Query\DataEntry\FindAllDataEntryQuery;
use App\Presentation\Resource\DataEntryResource;
use App\Shared\Presentation\AbstractProvider;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @extends parent<DataEntryResource>
 */
final class DataEntryCollectionProvider extends AbstractProvider
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
        $message = new FindAllDataEntryQuery(
            page: $this->pagination->getPage($context),
            itemsPerPage: $this->pagination->getLimit($operation, $context),
        );

        $collection = $this->dispatch($message);

        return $this->paginate(
            DataEntryResource::class,
            'fromArrayDomain',
            $collection,
        );
    }
}
