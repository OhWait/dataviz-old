<?php

declare(strict_types=1);

namespace App\Presentation\Datapool\State\Provider\AdministrativeDivision;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\Pagination\PartialPaginatorInterface;
use App\Application\Datapool\Query\FindAllPiicQuery;
use App\Domain\Datapool\Model\AdministrativeDivision\Piic;
use App\Presentation\Datapool\Resource\AdministrativeDivision\PiicResource;
use App\Shared\Presentation\AbstractProvider;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @extends parent<Piic>
 */
final class PiicCollectionProvider extends AbstractProvider
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
        $message = new FindAllPiicQuery(
            page: $this->pagination->getPage($context),
            itemsPerPage: $this->pagination->getLimit($operation, $context),
        );

        $collection = $this->dispatch($message);

        return $this->paginate(
            PiicResource::class,
            'fromArrayDomain',
            $collection,
        );
    }
}
