<?php

declare(strict_types=1);

namespace App\Presentation\Datapool\Resource\AdministrativeDivision;

use ApiPlatform\Metadata as API;
use ApiPlatform\OpenApi\Model;
use App\Domain\Datapool\Model\AdministrativeDivision\Department;
use App\Presentation\Datapool\State\Provider\AdministrativeDivision\DepartmentCollectionProvider;

#[API\ApiResource(
    routePrefix: '/administrative-division',
    operations: [
        new API\GetCollection(
            uriTemplate: '/department',
            openapi: new Model\Operation(
                tags: ['Administrative Division'],
                summary: 'Liste des départements',
                description: 'Récupère la liste de toutes les départements.',
            ),
            provider: DepartmentCollectionProvider::class,
            parameters: [
                new API\QueryParameter(
                    key: 'label',
                    schema: ['type' => 'string'],
                )
            ],
            formats: ['json'],
        ),
    ],
)]
class DepartmentResource
{
    public function __construct(
        public int $year,

        public string $codedep,

        public string $label,
    ) {
    }

    public static function fromDomain(Department $model): self
    {
        return new self(
            year: $model->year()->value,
            codedep: $model->code()->value,
            label: $model->label()->value,
        );
    }

    /**
     * @param Department[] $models
     *
     * @return self[]
     */
    public static function fromArrayDomain(array $models): array
    {
        return \array_map(
            fn (Department $model) => self::fromDomain($model),
            $models,
        );
    }
}
