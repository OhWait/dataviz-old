<?php

declare(strict_types=1);

namespace App\Application\Command\Dataset;

use App\Domain\ValueObject\Dataset\DatasetDataCreatedAt;
use App\Domain\ValueObject\Dataset\DatasetDataProvider;
use App\Domain\ValueObject\Dataset\DatasetDataUpdatedAt;
use App\Domain\ValueObject\Dataset\DatasetDescription;
use App\Domain\ValueObject\Dataset\DatasetGranularity;
use App\Domain\ValueObject\Dataset\DatasetLanguage;
use App\Domain\ValueObject\Dataset\DatasetPerimeter;
use App\Domain\ValueObject\Dataset\DatasetSecurity;
use App\Domain\ValueObject\Dataset\DatasetShortTitle;
use App\Domain\ValueObject\Dataset\DatasetSlug;
use App\Domain\ValueObject\Dataset\DatasetTitle;
use App\Domain\ValueObject\Dataset\DatasetUpdateFrequency;
use App\Domain\ValueObject\Dataset\DatasetUpdatePeriod;
use App\Domain\ValueObject\Provider\ProviderSlug;

final readonly class CreateDatasetCommand
{
    /**
     * @param string[] $themes
     */
    public function __construct(
        public DatasetSlug $slug,
        public DatasetTitle $title,
        public ?DatasetShortTitle $shortTitle,
        public ?DatasetDescription $description,
        public ?DatasetPerimeter $perimeter,
        public DatasetGranularity $granularity,
        public ?DatasetUpdateFrequency $updateFrequency,
        public ?DatasetUpdatePeriod $updatePeriod,
        public DatasetSecurity $security,
        public ?DatasetLanguage $language,
        public ?DatasetDataCreatedAt $dataCreatedAt,
        public ?DatasetDataUpdatedAt $dataUpdatedAt,
        public ?DatasetDataProvider $dataProvider,
        public ProviderSlug $provider,
        public array $themes,
    ) {
    }
}
