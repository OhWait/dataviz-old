<?php

declare(strict_types=1);

namespace App\Presentation\Resource;

use ApiPlatform\Metadata as API;
use ApiPlatform\OpenApi\Model;
use App\Domain\Model\Provider;
use App\Presentation\Enum\DatasetGroupEnum;
use App\Presentation\Enum\ProviderGroupEnum;
use App\Presentation\State\Processor\Provider\ProviderCreateProcessor;
use App\Presentation\State\Processor\Provider\ProviderDeleteProcessor;
use App\Presentation\State\Processor\Provider\ProviderUpdateProcessor;
use App\Presentation\State\Processor\Provider\ProviderUploadImageProcessor;
use App\Presentation\State\Provider\ProviderItemProvider;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[
    API\ApiResource(
        shortName: 'Provider',
        operations: [
            new API\Get(
                normalizationContext: [
                    'groups' => [ProviderGroupEnum::GET_COLLECTION, ProviderGroupEnum::GET],
                ],
                provider: ProviderItemProvider::class,
            ),

            new API\Post(
                denormalizationContext: [
                    'groups' => [ProviderGroupEnum::POST, ProviderGroupEnum::PATCH],
                ],
                normalizationContext: [
                    'groups' => [ProviderGroupEnum::GET_COLLECTION, ProviderGroupEnum::GET],
                ],
                processor: ProviderCreateProcessor::class,
            ),

            new API\Post(
                uriTemplate: '/provider/{slug}/upload-image',
                inputFormats: ['multipart' => ['multipart/form-data']],
                deserialize: false,
                openapi: new Model\Operation(
                    requestBody: new Model\RequestBody(
                        content: new \ArrayObject([
                            'multipart/form-data' => [
                                'schema' => [
                                    'type' => 'object', 
                                    'properties' => [
                                        'file' => [
                                            'type' => 'string', 
                                            'format' => 'binary'
                                        ]
                                    ]
                                ]
                            ]
                        ])
                    )
                ),
                denormalizationContext: [
                    'groups' => [ProviderGroupEnum::POST_IMAGE],
                ],
                normalizationContext: [
                    'groups' => [ProviderGroupEnum::GET_COLLECTION, ProviderGroupEnum::GET],
                ],
                processor: ProviderUploadImageProcessor::class,
            ),

            new API\Patch(
                denormalizationContext: [
                    'groups' => [ProviderGroupEnum::PATCH],
                ],
                normalizationContext: [
                    'groups' => [ProviderGroupEnum::GET_COLLECTION, ProviderGroupEnum::GET],
                ],
                provider: ProviderItemProvider::class,
                processor: ProviderUpdateProcessor::class,
            ),

            new API\Delete(
                provider: ProviderItemProvider::class,
                processor: ProviderDeleteProcessor::class,
            ),
        ],
    )
]
class ProviderResource
{
    public function __construct(
        #[
            Assert\NotBlank(),
            Assert\Length(max: 255),
            API\ApiProperty(
                identifier: true,
                writable: true,
                readable: true,
                required: true,
            ),
            Groups([
                ProviderGroupEnum::GET_COLLECTION,
                ProviderGroupEnum::POST,
                ProviderGroupEnum::POST_IMAGE,
                DatasetGroupEnum::GET_COLLECTION,
            ]),
        ]
        public ?string $slug = null,

        #[
            Assert\NotBlank(),
            Assert\Length(max: 255),
            Groups([
                ProviderGroupEnum::GET_COLLECTION,
                ProviderGroupEnum::PATCH,
                DatasetGroupEnum::GET_COLLECTION,
            ])
        ]
        public ?string $name = null,

        #[
            Assert\NotBlank(options: ['allowNull' => true]),
            Assert\Length(max: 255),
            Groups([
                ProviderGroupEnum::GET_COLLECTION,
                ProviderGroupEnum::PATCH,
                DatasetGroupEnum::GET_COLLECTION,
            ]),
        ]
        public ?string $acronym = null,

        #[
            Assert\NotBlank(options: ['allowNull' => true]),
            Groups([
                ProviderGroupEnum::GET,
                ProviderGroupEnum::PATCH,
                DatasetGroupEnum::GET,
            ]),
        ]
        public ?string $description = null,

        #[
            API\ApiProperty(writable: false),
            Groups([ProviderGroupEnum::GET_COLLECTION]),
        ]
        public ?string $image = null,

        #[Groups([ProviderGroupEnum::POST_IMAGE])]
        public ?File $file = null,
    ) {
    }

    public static function fromDomain(Provider $provider): self
    {
        return new self(
            $provider->slug()->value,
            $provider->name()->value,
            $provider->acronym()->value,
            $provider->description()->value,
            $provider->image()->value,
        );
    }
}
