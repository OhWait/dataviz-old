<?php

declare(strict_types=1);

namespace App\Presentation\Dataviz\Resource;

use ApiPlatform\Metadata as API;
use App\Domain\Dataviz\Model\Theme;
use App\Presentation\Dataviz\Enum\DatasetGroupEnum;
use App\Presentation\Dataviz\State\Provider\ThemeItemProvider;
use Symfony\Component\Serializer\Annotation\Groups;

#[API\ApiResource(
    shortName: 'Theme',
    operations: [
        new API\Get(
            provider: ThemeItemProvider::class,
        ),
    ],
)]
class ThemeResource
{
    public function __construct(
        #[API\ApiProperty(identifier: true, required: true)]
        #[Groups([DatasetGroupEnum::GET_COLLECTION])]
        public string $slug,

        #[API\ApiProperty(required: true)]
        #[Groups([DatasetGroupEnum::GET_COLLECTION])]
        public string $title,
    ) {
    }

    public static function fromDomain(Theme $theme): self
    {
        return new self(
            slug: $theme->slug()->value,
            title: $theme->title()->value,
        );
    }

    /**
     * @param Theme[] $collection
     *
     * @return self[]
     */
    public static function fromArrayDomain(array $collection): array
    {
        return \array_map(
            fn (Theme $collection): ThemeResource => self::fromDomain($collection),
            $collection,
        );
    }
}
