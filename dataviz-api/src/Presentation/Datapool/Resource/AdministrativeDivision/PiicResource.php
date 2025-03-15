<?php

declare(strict_types=1);

namespace App\Presentation\Datapool\Resource\AdministrativeDivision;

use ApiPlatform\Metadata as API;
use ApiPlatform\OpenApi\Model;
use App\Domain\Datapool\Model\AdministrativeDivision\Piic;
use App\Presentation\Datapool\Enum\AdministrativeGroupEnum;
use App\Presentation\Datapool\State\Provider\AdministrativeDivision\PiicCollectionProvider;
use Symfony\Component\Serializer\Annotation\Groups;

#[API\ApiResource(
    routePrefix: '/administrative-division',
    shortName: 'Piic',
    operations: [
        new API\GetCollection(
            uriTemplate: '/piic',
            normalizationContext: [
                'groups' => [AdministrativeGroupEnum::PIIC],
            ],
            openapi: new Model\Operation(
                tags: ['Administrative Division'],
                summary: 'Liste des EPCI',
                description: 'Récupère la liste de toutes les EPCI.',
            ),
            provider: PiicCollectionProvider::class,
            parameters: [
                new API\QueryParameter(
                    key: 'label',
                    schema: ['type' => 'string'],
                )
            ],
        ),
    ],
)]
class PiicResource
{
    public function __construct(
        public int $year,

        #[API\ApiProperty(identifier: true, required: true)]
        #[Groups([AdministrativeGroupEnum::MUNICIPALITY, AdministrativeGroupEnum::PIIC])]
        public string $epci,

        #[Groups([AdministrativeGroupEnum::MUNICIPALITY, AdministrativeGroupEnum::PIIC])]
        public string $label,

        #[Groups([AdministrativeGroupEnum::MUNICIPALITY, AdministrativeGroupEnum::PIIC])]
        public string $nature,

        #[Groups([AdministrativeGroupEnum::PIIC])]
        public int $nbMunicipalities = 0,
    ) {}

    public static function fromDomain(Piic $model): self
    {
        return new self(
            year: $model->year()->value,
            epci: $model->code()->value,
            label: $model->label()->value,
            nature: $model->nature()->value,
            nbMunicipalities: $model->nbMunicipalities(),
        );
    }

    /**
     * @return self[]
     */
    public static function fromArrayDomain(array $models): array
    {
        return \array_map(
            fn(Piic $model) => self::fromDomain($model),
            $models,
        );
    }
}
