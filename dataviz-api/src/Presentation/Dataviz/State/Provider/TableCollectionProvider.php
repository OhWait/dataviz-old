<?php

declare(strict_types=1);

namespace App\Presentation\Dataviz\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\Pagination\PartialPaginatorInterface;
use App\Application\Datapool\Query\FindPaginatedDataQuery;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntrySlug;
use App\Presentation\Dataviz\Resource\DataEntryResource;
use App\Shared\Infrastructure\ApiPlatform\Paginator;
use App\Shared\Presentation\AbstractProvider;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @extends parent<DataEntryResource>
 */
final class TableCollectionProvider extends AbstractProvider
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
        $query = new FindPaginatedDataQuery(
            new DataEntrySlug($uriVariables['slug']),
            $this->pagination->getPage($context),
            $this->pagination->getLimit($operation, $context),
        );

        $paginator = $this->dispatch($query);

        return new Paginator(
            new \ArrayObject(
                $paginator->getIterator(),
            ),
            $paginator->getCurrentPage(),
            $paginator->getItemsPerPage(),
            $paginator->getTotalItems(),
        );
    }
}
