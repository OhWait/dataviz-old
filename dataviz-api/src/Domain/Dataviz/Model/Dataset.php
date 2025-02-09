<?php

declare(strict_types=1);

namespace App\Domain\Dataviz\Model;

use App\Domain\Dataviz\ValueObject\Dataset\DatasetCreatedAt;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetDataCreatedAt;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetDataProvider;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetDataUpdatedAt;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetDescription;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetGranularity;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetLanguage;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetPerimeter;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetSecurity;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetShortTitle;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetSlug;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetTitle;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetUpdatedAt;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetUpdateFrequency;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetUpdatePeriod;
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
    #[ORM\ManyToMany(targetEntity: Theme::class, inversedBy: 'datasets', cascade: ['persist'])]
    #[ORM\JoinTable(
        name: 'theme_dataset',
        joinColumns: [new ORM\JoinColumn(name: 'dataset', referencedColumnName: 'slug', onDelete: 'CASCADE')],
        inverseJoinColumns: [new ORM\JoinColumn(name: 'theme', referencedColumnName: 'slug', onDelete: 'CASCADE')],
    )]
    private Collection $themes;

    #[ORM\Embedded(columnPrefix: false)]
    private DatasetCreatedAt $createdAt;

    #[ORM\Embedded(columnPrefix: false)]
    private DatasetUpdatedAt $updatedAt;

    /**
     * @param Theme[]     $themes
     * @param DataEntry[] $dataEntries
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

        array $dataEntries = [],
    ) {
        $this->dataEntries = new ArrayCollection($dataEntries);
        $this->themes = new ArrayCollection($themes);
        $this->createdAt = new DatasetCreatedAt();
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
