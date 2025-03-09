<?php

declare(strict_types=1);

namespace App\Presentation\Datapool\Resource\AdministrativeDivision;

use ApiPlatform\Metadata as API;
use ApiPlatform\OpenApi\Model;
use App\Domain\Datapool\Model\AdministrativeDivision\Municipality;
use App\Presentation\Datapool\State\Provider\AdministrativeDivision\MunicipalityCollectionProvider;

#[API\ApiResource(
    routePrefix: '/administrative-division',
    operations: [
        new API\GetCollection(
            uriTemplate: '/municipality',
            openapi: new Model\Operation(
                tags: ['Administrative Division'],
                summary: 'Liste des communes',
                description: 'Récupère la liste de toutes les communes.',
            ),
            provider: MunicipalityCollectionProvider::class,
            output: MunicipalityResource::class,
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
class MunicipalityResource
{
    public function __construct(
        #[API\ApiProperty(identifier: true, required: true)]
        public string $codgeo,

        public string $label,
    ) {}

    public static function fromDomain(Municipality $model): self
    {
        return new self(
            codgeo: $model->codgeo()->value,
            label: $model->label()->value,
        );
    }

    /**
     * @return self[]
     */
    public static function fromArrayDomain(array $models): array
    {
        return \array_map(
            fn(Municipality $model) => self::fromDomain($model),
            $models,
        );
    }
}
