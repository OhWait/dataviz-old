<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\ValueObject\Dataset\DatasetCreatedAt;
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
use App\Domain\ValueObject\Dataset\DatasetUpdatedAt;
use App\Domain\ValueObject\Dataset\DatasetUpdateFrequency;
use App\Domain\ValueObject\Dataset\DatasetUpdatePeriod;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table('dataset')]
class Dataset
{
    /** @var Collection<int, DataEntry> */
    #[ORM\OneToMany(mappedBy: 'dataset', targetEntity: DataEntry::class, orphanRemoval: true)]
    private Collection $dataEntries;

    /** @var Collection<int, Theme> */
    #[ORM\JoinTable(name: 'theme_dataset')]
    #[ORM\JoinColumn(name: 'dataset', referencedColumnName: 'slug')]
    #[ORM\InverseJoinColumn(name: 'theme', referencedColumnName: 'slug')]
    #[ORM\ManyToMany(targetEntity: Theme::class, inversedBy: 'datasets', cascade: ['persist'])]
    private Collection $themes;

    #[ORM\Embedded(columnPrefix: false)]
    private DatasetCreatedAt $createdAt;

    #[ORM\Embedded(columnPrefix: false)]
    private DatasetUpdatedAt $updatedAt;

    /**
     * @param Theme[] $themes
     */
    public function __construct(
        #[ORM\Embedded(columnPrefix: false)]
        private DatasetSlug $slug,

        #[ORM\Embedded(columnPrefix: false)]
        private DatasetTitle $title,

        #[ORM\Embedded(columnPrefix: false)]
        private DatasetShortTitle $shortTitle,

        #[ORM\Embedded(columnPrefix: false)]
        private DatasetDescription $description,

        #[ORM\Embedded(columnPrefix: false)]
        private DatasetPerimeter $perimeter,

        #[ORM\Embedded(columnPrefix: false)]
        private DatasetGranularity $granularity,

        #[ORM\Embedded(columnPrefix: false)]
        private DatasetUpdateFrequency $updateFrequency,

        #[ORM\Embedded(columnPrefix: false)]
        private DatasetUpdatePeriod $updatePeriod,

        #[ORM\Embedded(columnPrefix: false)]
        private DatasetSecurity $security,

        #[ORM\Embedded(columnPrefix: false)]
        private DatasetLanguage $language,

        #[ORM\Embedded(columnPrefix: false)]
        private DatasetDataCreatedAt $dataCreatedAt,

        #[ORM\Embedded(columnPrefix: false)]
        private DatasetDataUpdatedAt $dataUpdatedAt,

        #[ORM\Embedded(columnPrefix: false)]
        private DatasetDataProvider $dataProvider,

        #[ORM\ManyToOne(inversedBy: 'datasets')]
        #[ORM\JoinColumn(nullable: false, referencedColumnName: 'slug')]
        private Provider $provider,

        array $themes = [],
    ) {
        $this->dataEntries = new ArrayCollection();
        $this->createdAt = new DatasetCreatedAt();
        $this->updatedAt = new DatasetUpdatedAt();
        $this->themes = new ArrayCollection($themes);
    }

    /**
     * @param Theme[] $themes
     */
    public function update(
        ?DatasetSlug $slug = null,
        ?DatasetTitle $title = null,
        ?DatasetShortTitle $shortTitle = null,
        ?DatasetDescription $description = null,
        ?DatasetPerimeter $perimeter = null,
        ?DatasetGranularity $granularity = null,
        ?DatasetUpdateFrequency $updateFrequency = null,
        ?DatasetUpdatePeriod $updatePeriod = null,
        ?DatasetSecurity $security = null,
        ?DatasetLanguage $language = null,
        ?DatasetDataCreatedAt $dataCreatedAt = null,
        ?DatasetDataUpdatedAt $dataUpdatedAt = null,
        ?DatasetDataProvider $dataProvider = null,
        Provider $provider = null,
        array $themes = null,
    ): void {
        $this->slug = $slug ?? $this->slug;
        $this->title = $title ?? $this->title;
        $this->shortTitle = $shortTitle ?? $this->shortTitle;
        $this->description = $description ?? $this->description;
        $this->perimeter = $perimeter ?? $this->$perimeter;
        $this->granularity = $granularity ?? $this->granularity;
        $this->updateFrequency = $updateFrequency ?? $this->updateFrequency;
        $this->updatePeriod = $updatePeriod ?? $this->updatePeriod;
        $this->security = $security ?? $this->security;
        $this->language = $language ?? $this->language;
        $this->dataCreatedAt = $dataCreatedAt ?? $this->dataCreatedAt;
        $this->dataUpdatedAt = $dataUpdatedAt ?? $this->dataUpdatedAt;
        $this->dataProvider = $dataProvider ?? $this->dataProvider;
        $this->provider = $provider ?? $this->provider;
        $this->themes = null !== $themes ? new ArrayCollection($themes) : $this->themes;
        $this->updatedAt = new DatasetUpdatedAt();
    }

    public function slug(): DatasetSlug
    {
        return $this->slug;
    }

    public function title(): DatasetTitle
    {
        return $this->title;
    }

    public function shortTitle(): DatasetShortTitle
    {
        return $this->shortTitle;
    }

    public function description(): DatasetDescription
    {
        return $this->description;
    }

    public function perimeter(): DatasetPerimeter
    {
        return $this->perimeter;
    }

    public function granularity(): DatasetGranularity
    {
        return $this->granularity;
    }

    public function updateFrequency(): DatasetUpdateFrequency
    {
        return $this->updateFrequency;
    }

    public function updatePeriod(): DatasetUpdatePeriod
    {
        return $this->updatePeriod;
    }

    public function security(): DatasetSecurity
    {
        return $this->security;
    }

    public function language(): DatasetLanguage
    {
        return $this->language;
    }

    public function dataCreatedAt(): DatasetDataCreatedAt
    {
        return $this->dataCreatedAt;
    }

    public function dataUpdatedAt(): DatasetDataUpdatedAt
    {
        return $this->dataUpdatedAt;
    }

    public function dataProvider(): DatasetDataProvider
    {
        return $this->dataProvider;
    }

    public function provider(): Provider
    {
        return $this->provider;
    }

    /**
     * @return Collection<int, DataEntry>
     */
    public function dataEntries(): Collection
    {
        return $this->dataEntries;
    }

    /**
     * @return Collection<int, Theme>
     */
    public function themes(): Collection
    {
        return $this->themes;
    }

    public function createdAt(): DatasetCreatedAt
    {
        return $this->createdAt;
    }

    public function updatedAt(): DatasetUpdatedAt
    {
        return $this->updatedAt;
    }
}
