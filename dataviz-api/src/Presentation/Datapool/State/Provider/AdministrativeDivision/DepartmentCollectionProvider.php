<?php

declare(strict_types=1);

namespace App\Presentation\Datapool\State\Provider\AdministrativeDivision;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\Pagination\PartialPaginatorInterface;
use App\Application\Datapool\Query\FindAllDepartmentQuery;
use App\Domain\Datapool\Model\AdministrativeDivision\Department;
use App\Presentation\Datapool\Resource\AdministrativeDivision\DepartmentResource;
use App\Shared\Presentation\AbstractProvider;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @extends parent<Department>
 */
final class DepartmentCollectionProvider extends AbstractProvider
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
        $queryParameters = $context['filters'] ?? [];

        $message = new FindAllDepartmentQuery(
            page: $this->pagination->getPage($context),
            itemsPerPage: $this->pagination->getLimit($operation, $context),
            label: $queryParameters['label'] ?? null,
        );

        $collection = $this->dispatch($message);

        return $this->paginate(
            DepartmentResource::class,
            'fromArrayDomain',
            $collection,
        );
    }
}
