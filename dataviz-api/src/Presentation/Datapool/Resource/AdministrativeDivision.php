<?php

declare(strict_types=1);

namespace App\Presentation\Datapool\Resource;

use ApiPlatform\Metadata as API;
use ApiPlatform\OpenApi\Model;
use App\Presentation\Datapool\Resource\AdministrativeDivision\DepartmentResource;
use App\Presentation\Datapool\Resource\AdministrativeDivision\MunicipalityResource;
use App\Presentation\Datapool\Resource\AdministrativeDivision\PiicResource;
use App\Presentation\Datapool\State\Provider\AdministrativeDivision\DepartmentCollectionProvider;
use App\Presentation\Datapool\State\Provider\AdministrativeDivision\MunicipalityCollectionProvider;
use App\Presentation\Datapool\State\Provider\AdministrativeDivision\PiicCollectionProvider;

#[API\ApiResource(
    shortName: 'AdministrativeDivision',
    routePrefix: '/administrative-division',
    operations: [
        new API\GetCollection(
            uriTemplate: '/municipality',
            openapi: new Model\Operation(
                summary: 'Collection des communes',
                description: 'Retrieves the collection of municipalities resources.',
            ),
            provider: MunicipalityCollectionProvider::class,
            output: MunicipalityResource::class,
        ),

        new API\GetCollection(
            uriTemplate: '/piic',
            openapi: new Model\Operation(
                summary: 'Collection des établissements publics de coopération intercommunale (EPCI).',
                description: 'Retrieves the collection of Public institution for inter-municipal cooperation (PIIC).',
            ),
            provider: PiicCollectionProvider::class,
            output: PiicResource::class,
        ),

        new API\GetCollection(
            uriTemplate: '/department',
            provider: DepartmentCollectionProvider::class,
            output: DepartmentResource::class,
        ),
    ],
)]
class AdministrativeDivision
{
}
