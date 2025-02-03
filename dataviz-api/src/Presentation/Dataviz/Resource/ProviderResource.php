<?php

declare(strict_types=1);

namespace App\Presentation\Dataviz\Resource;

use ApiPlatform\Metadata as API;
use App\Domain\Dataviz\Model\Provider;
use App\Presentation\Dataviz\Enum\DatasetGroupEnum;
use App\Presentation\Dataviz\Enum\ProviderGroupEnum;
use App\Presentation\Dataviz\State\Provider\ProviderItemProvider;
use Symfony\Component\Serializer\Annotation\Groups;

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
        ],
    )
]
class ProviderResource
{
    private const IMAGE_PREFIX_URL = '/media/provider/';

    public function __construct(
        #[
            API\ApiProperty(
                identifier: true,
                writable: true,
                readable: true,
                required: true,
            ),
            Groups([
                ProviderGroupEnum::GET_COLLECTION,
                DatasetGroupEnum::GET_COLLECTION,
            ]),
        ]
        public string $slug,

        #[
            Groups([
                ProviderGroupEnum::GET_COLLECTION,
                DatasetGroupEnum::GET_COLLECTION,
            ])
        ]
        public string $name,

        #[
            Groups([
                ProviderGroupEnum::GET_COLLECTION,
                DatasetGroupEnum::GET_COLLECTION,
            ]),
        ]
        public ?string $acronym,

        #[
            Groups([
                ProviderGroupEnum::GET,
                DatasetGroupEnum::GET,
            ]),
        ]
        public ?string $description,

        #[
            Groups([
                ProviderGroupEnum::GET_COLLECTION,
                DatasetGroupEnum::GET_COLLECTION,
            ]),
        ]
        public ?string $image,
    ) {
    }

    public static function fromDomain(Provider $provider): self
    {
        return new self(
            $provider->slug()->value,
            $provider->name()->value,
            $provider->acronym()->value,
            $provider->description()->value,
            $provider->image()->value ? self::IMAGE_PREFIX_URL.$provider->image()->value : null,
        );
    }
}
