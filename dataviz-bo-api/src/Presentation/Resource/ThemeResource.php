<?php

declare(strict_types=1);

namespace App\Presentation\Resource;

use ApiPlatform\Metadata as API;
use App\Domain\Model\Theme;
use App\Presentation\Enum\DatasetGroupEnum;
use App\Presentation\Enum\ThemeGroupEnum;
use App\Presentation\State\Processor\Theme\ThemeCreateProcessor;
use App\Presentation\State\Processor\Theme\ThemeDeleteProcessor;
use App\Presentation\State\Processor\Theme\ThemeUpdateProcessor;
use App\Presentation\State\Provider\ThemeItemProvider;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[
    API\ApiResource(
        shortName: 'Theme',
        operations: [
            new API\Get(
                provider: ThemeItemProvider::class,
            ),

            new API\Post(
                denormalizationContext: [
                    'groups' => [ThemeGroupEnum::POST, ThemeGroupEnum::PATCH],
                ],
                normalizationContext: [
                    'groups' => [ThemeGroupEnum::GET_COLLECTION, ThemeGroupEnum::GET],
                ],
                processor: ThemeCreateProcessor::class,
            ),

            new API\Patch(
                denormalizationContext: [
                    'groups' => [ThemeGroupEnum::PATCH],
                ],
                normalizationContext: [
                    'groups' => [ThemeGroupEnum::GET_COLLECTION, ThemeGroupEnum::GET],
                ],
                provider: ThemeItemProvider::class,
                processor: ThemeUpdateProcessor::class,
            ),

            new API\Delete(
                provider: ThemeItemProvider::class,
                processor: ThemeDeleteProcessor::class,
            ),
        ],
    )
]
class ThemeResource
{
    public function __construct(
        #[
            Assert\NotBlank(),
            API\ApiProperty(
                identifier: true,
                writable: true,
                readable: true,
                required: true,
            ),
            Groups([
                ThemeGroupEnum::GET_COLLECTION,
                ThemeGroupEnum::POST,
                DatasetGroupEnum::GET_COLLECTION,
            ])
        ]
        public ?string $slug = null,

        #[
            Assert\NotBlank(),
            Groups([
                ThemeGroupEnum::GET_COLLECTION,
                ThemeGroupEnum::PATCH,
                DatasetGroupEnum::GET_COLLECTION,
            ])
        ]
        public ?string $title = null,
    ) {
    }

    public static function fromDomain(Theme $theme): self
    {
        return new self(
            $theme->slug()->value,
            $theme->title()->value,
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
            fn (Theme $collection) => self::fromDomain($collection),
            $collection,
        );
    }
}
