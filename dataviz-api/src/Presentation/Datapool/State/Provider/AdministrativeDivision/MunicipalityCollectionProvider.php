<?php

declare(strict_types=1);

namespace App\Presentation\Datapool\State\Provider\AdministrativeDivision;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\Pagination\PartialPaginatorInterface;
use App\Application\Datapool\Query\FindAllMunicipalityQuery;
use App\Domain\Datapool\Model\AdministrativeDivision\Municipality;
use App\Presentation\Datapool\Resource\AdministrativeDivision\MunicipalityResource;
use App\Shared\Presentation\AbstractProvider;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @extends parent<Municipality>
 */
final class MunicipalityCollectionProvider extends AbstractProvider
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
        $message = new FindAllMunicipalityQuery(
            page: $this->pagination->getPage($context),
            itemsPerPage: $this->pagination->getLimit($operation, $context),
        );

        $collection = $this->dispatch($message);

        return $this->paginate(
            MunicipalityResource::class,
            'fromArrayDomain',
            $collection,
        );
    }
}
