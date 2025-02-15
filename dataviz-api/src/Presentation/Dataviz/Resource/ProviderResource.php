<?php

declare(strict_types=1);

namespace App\Presentation\Dataviz\Resource;

use ApiPlatform\Metadata as API;
use App\Domain\Dataviz\Model\Provider;
use App\Presentation\Dataviz\Enum\DatasetGroupEnum;
use App\Presentation\Dataviz\Enum\ProviderGroupEnum;
use App\Presentation\Dataviz\State\Provider\ProviderItemProvider;
use Symfony\Component\Serializer\Annotation\Groups;

#[API\ApiResource(
    shortName: 'Provider',
    operations: [
        new API\Get(
            normalizationContext: [
                'groups' => [ProviderGroupEnum::GET],
            ],
            provider: ProviderItemProvider::class,
        ),
    ],
)]
class ProviderResource
{
    private const IMAGE_PREFIX_URL = '/media/provider/';

    public function __construct(
        #[API\ApiProperty(identifier: true, required: true)]
        #[Groups([ProviderGroupEnum::GET, DatasetGroupEnum::GET_COLLECTION])]
        public string $slug,

        #[API\ApiProperty(required: true)]
        #[Groups([ProviderGroupEnum::GET, DatasetGroupEnum::GET_COLLECTION])]
        public string $name,

        #[Groups([ProviderGroupEnum::GET, DatasetGroupEnum::GET_COLLECTION])]
        public ?string $acronym,

        #[Groups([ProviderGroupEnum::GET, DatasetGroupEnum::GET])]
        public ?string $description,

        #[Groups([ProviderGroupEnum::GET, DatasetGroupEnum::GET_COLLECTION])]
        public ?string $image,
    ) {
    }

    public static function fromDomain(Provider $provider): self
    {
        return new self(
            slug: $provider->slug()->value,
            name: $provider->name()->value,
            acronym: $provider->acronym()->value,
            description: $provider->description()->value,
            image: $provider->image()->value ? self::IMAGE_PREFIX_URL.$provider->image()->value : null,
        );
    }
}
