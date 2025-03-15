<?php

declare(strict_types=1);

namespace App\Presentation\Datapool\Resource\AdministrativeDivision;

use ApiPlatform\Metadata as API;
use ApiPlatform\OpenApi\Model;
use App\Domain\Datapool\Model\AdministrativeDivision\Municipality;
use App\Presentation\Datapool\Enum\AdministrativeGroupEnum;
use App\Presentation\Datapool\State\Provider\AdministrativeDivision\MunicipalityCollectionProvider;
use Symfony\Component\Serializer\Annotation\Groups;

#[API\ApiResource(
    routePrefix: '/administrative-division',
    shortName: 'Municipality',
    operations: [
        new API\GetCollection(
            uriTemplate: '/municipality',
            normalizationContext: [
                'groups' => [AdministrativeGroupEnum::MUNICIPALITY],
            ],
            openapi: new Model\Operation(
                tags: ['Administrative Division'],
                summary: 'Liste des communes',
                description: 'Récupère la liste de toutes les communes.',
            ),
            provider: MunicipalityCollectionProvider::class,
            parameters: [
                new API\QueryParameter(
                    key: 'label',
                    schema: ['type' => 'string'],
                )
            ],
        ),
    ],
)]
class MunicipalityResource
{
    public function __construct(
        public int $annee,

        #[API\ApiProperty(identifier: true, required: true)]
        #[Groups([AdministrativeGroupEnum::MUNICIPALITY])]
        public string $codgeo,

        #[Groups([AdministrativeGroupEnum::MUNICIPALITY])]
        public string $label,
        
        #[Groups([AdministrativeGroupEnum::MUNICIPALITY])]
        public DepartmentResource $department,

        #[Groups([AdministrativeGroupEnum::MUNICIPALITY])]
        public ?PiicResource $piic = null,
    ) {}

    public static function fromDomain(Municipality $model): self
    {
        return new self(
            annee: $model->year()->value,
            codgeo: $model->codgeo()->value,
            label: $model->label()->value,
            piic: $model->piic() ? PiicResource::fromDomain($model->piic()) : null,
            department: DepartmentResource::fromDomain($model->department()),
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
