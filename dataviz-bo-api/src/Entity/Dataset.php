<?php

namespace App\Entity;

use ApiPlatform\Metadata as API;
use App\Enum\Dataset\DataProviderEnum;
use App\Enum\Dataset\FrequencyEnum;
use App\Enum\Dataset\GranularityEnum;
use App\Enum\Dataset\LanguageEnum;
use App\Enum\Dataset\SecurityEnum;
use App\Enum\Group\DataEntryGroupEnum;
use App\Enum\Group\DatasetGroupEnum;
use App\Enum\Group\ProviderGroupEnum;
use App\Enum\Group\ThemeGroupEnum;
use App\Repository\DatasetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DatasetRepository::class)]
#[ORM\Table('dataset')]
#[API\ApiResource(
    operations: [
        new API\GetCollection(
            normalizationContext: ['groups' => [DatasetGroupEnum::GET_COLLECTION]],
            parameters: [
                new API\QueryParameter(
                    key: 'themes',
                    schema: [
                        'type' => 'array',
                        'items' => ['type' => 'string'],
                    ],
                ),
            ],
        ),

        new API\Get(
            normalizationContext: [
                'groups' => [
                    DatasetGroupEnum::GET_COLLECTION,
                    DatasetGroupEnum::GET,
                ],
            ],
        ),

        new API\Post(
            denormalizationContext: [
                'groups' => [
                    DatasetGroupEnum::POST, 
                    DatasetGroupEnum::PATCH,
                ],
                'disable_type_enforcement' => true,
            ],
            normalizationContext: [
                'groups' => [
                    DatasetGroupEnum::GET_COLLECTION, 
                    DatasetGroupEnum::GET,
                ],
            ],
        ),

        new API\Patch(
            denormalizationContext: [
                'groups' => [DatasetGroupEnum::PATCH],
                'disable_type_enforcement' => true,
            ],
            normalizationContext: [
                'groups' => [
                    DatasetGroupEnum::GET_COLLECTION,
                    DatasetGroupEnum::GET
                ],
            ],
        ),

        new API\Delete(),
    ],
)]
class Dataset
{
    /** @var Collection<int, DataEntry> */
    #[ORM\OneToMany(mappedBy: 'dataset', targetEntity: DataEntry::class, orphanRemoval: true)]
    #[Groups([DatasetGroupEnum::GET])]
    private Collection $dataEntries;

    /**  @var Collection<int, Theme> */
    #[ORM\ManyToMany(targetEntity: Theme::class, inversedBy: 'datasets')]
    #[ORM\JoinTable(
        name: 'theme_dataset',
        joinColumns: [new ORM\JoinColumn(name: 'dataset', referencedColumnName: 'slug', onDelete: 'CASCADE')],
        inverseJoinColumns: [new ORM\JoinColumn(name: 'theme', referencedColumnName: 'slug', onDelete: 'CASCADE')],
    )]
    #[Groups([DatasetGroupEnum::GET, DatasetGroupEnum::GET_COLLECTION, DatasetGroupEnum::PATCH])]
    private $themes;

    #[ORM\Column]
    #[Groups([DatasetGroupEnum::GET])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups([DatasetGroupEnum::GET])]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct(
        #[ORM\Id]
        #[ORM\Column(length: 255, unique: true)]
        #[API\ApiProperty(identifier: true, readable: true, writable: true, required: true)]
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        #[Groups([
            DatasetGroupEnum::GET_COLLECTION,
            DatasetGroupEnum::POST,
            ThemeGroupEnum::GET,
            ProviderGroupEnum::GET,
        ])]
        private $slug = null,

        #[ORM\Column(length: 255)]
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        #[Groups([
            DatasetGroupEnum::GET_COLLECTION,
            DatasetGroupEnum::PATCH,
            DataEntryGroupEnum::GET_COLLECTION,
            ThemeGroupEnum::GET,
            ProviderGroupEnum::GET,
        ])]
        private $title = null,

        #[ORM\Column(length: 255, nullable: true)]
        #[Assert\NotBlank(allowNull: true)]
        #[Assert\Length(max: 255)]
        #[Groups([DatasetGroupEnum::GET_COLLECTION, DatasetGroupEnum::PATCH, DataEntryGroupEnum::GET_COLLECTION])]
        private $shortTitle = null,

        #[ORM\Column(type: Types::TEXT, nullable: true)]
        #[Assert\NotBlank(allowNull: true)]
        #[Groups([DatasetGroupEnum::GET, DatasetGroupEnum::PATCH])]
        private $description = null,

        #[ORM\Column(type: Types::TEXT)]
        #[Assert\NotBlank()]
        #[Assert\Length(max: 255)]
        #[Groups([DatasetGroupEnum::GET_COLLECTION, DatasetGroupEnum::PATCH])]
        private $perimeter = null,

        #[ORM\Column(length: 255)]
        #[Assert\NotBlank]
        #[Assert\Choice(callback: [GranularityEnum::class, 'getValues'])]
        #[Groups([DatasetGroupEnum::GET_COLLECTION, DatasetGroupEnum::PATCH])]
        private $granularity = null,

        #[ORM\Column(length: 255, nullable: true)]
        #[Assert\Choice(callback: [FrequencyEnum::class, 'getValues'])]
        #[Groups([DatasetGroupEnum::GET_COLLECTION, DatasetGroupEnum::PATCH])]
        private $updateFrequency = null,

        #[ORM\Column(length: 255, nullable: true)]
        #[Assert\NotBlank(allowNull: true)]
        #[Assert\Length(max: 255)]
        #[Groups([DatasetGroupEnum::GET_COLLECTION, DatasetGroupEnum::PATCH])]
        private $updatePeriod = null,

        #[ORM\Column(length: 255)]
        #[Assert\NotBlank]
        #[Assert\Choice(callback: [SecurityEnum::class, 'getValues'])]
        #[Groups([DatasetGroupEnum::GET_COLLECTION, DatasetGroupEnum::PATCH])]
        private $security = null,

        #[ORM\Column(length: 255, nullable: true)]
        #[Assert\Choice(callback: [LanguageEnum::class, 'getValues'])]
        #[Groups([DatasetGroupEnum::GET_COLLECTION, DatasetGroupEnum::PATCH])]
        private $language = null,

        #[ORM\Column(nullable: true, type: Types::DATE_MUTABLE)]
        #[API\ApiProperty(openapiContext: ['type' => 'string', 'format' => 'date'])]
        #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
        #[Groups([DatasetGroupEnum::GET_COLLECTION, DatasetGroupEnum::PATCH])]
        private $dataCreatedAt = null,

        #[ORM\Column(nullable: true, type: Types::DATE_MUTABLE)]
        #[API\ApiProperty(openapiContext: ['type' => 'string', 'format' => 'date'])]
        #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
        #[Groups([DatasetGroupEnum::GET_COLLECTION, DatasetGroupEnum::PATCH])]
        private $dataUpdatedAt = null,

        #[ORM\Column(length: 255, nullable: true)]
        #[Assert\Choice(callback: [DataProviderEnum::class, 'getValues'])]
        #[Groups([DatasetGroupEnum::GET_COLLECTION, DatasetGroupEnum::PATCH])]
        private $dataProvider = null,

        #[ORM\ManyToOne(targetEntity: Provider::class, inversedBy: 'datasets')]
        #[ORM\JoinColumn(nullable: false, referencedColumnName: 'slug')]
        #[Assert\NotNull]
        #[Groups([DatasetGroupEnum::GET_COLLECTION, DatasetGroupEnum::PATCH])]
        private $provider = null,

        #[Groups([DatasetGroupEnum::GET_COLLECTION, DatasetGroupEnum::PATCH])]
        $themes = [],
    ) {
        $this->themes = new ArrayCollection($themes);
        $this->dataEntries = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getShortTitle(): ?string
    {
        return $this->shortTitle;
    }

    public function setShortTitle(?string $shortTitle): static
    {
        $this->shortTitle = $shortTitle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPerimeter(): ?string
    {
        return $this->perimeter;
    }

    public function setPerimeter(string $perimeter): static
    {
        $this->perimeter = $perimeter;

        return $this;
    }

    public function getGranularity(): ?string
    {
        return $this->granularity;
    }

    public function setGranularity(string $granularity): static
    {
        $this->granularity = $granularity;

        return $this;
    }

    public function getUpdateFrequency(): ?string
    {
        return $this->updateFrequency;
    }

    public function setUpdateFrequency(?string $updateFrequency): static
    {
        $this->updateFrequency = $updateFrequency;

        return $this;
    }

    public function getUpdatePeriod(): ?string
    {
        return $this->updatePeriod;
    }

    public function setUpdatePeriod(?string $updatePeriod): static
    {
        $this->updatePeriod = $updatePeriod;

        return $this;
    }

    public function getSecurity(): ?string
    {
        return $this->security;
    }

    public function setSecurity(string $security): static
    {
        $this->security = $security;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): static
    {
        $this->language = $language;

        return $this;
    }

    public function getDataCreatedAt(): ?\DateTimeInterface
    {
        return $this->dataCreatedAt;
    }

    public function setDataCreatedAt(?\DateTimeInterface $dataCreatedAt): static
    {
        $this->dataCreatedAt = $dataCreatedAt;

        return $this;
    }

    public function getDataUpdatedAt(): ?\DateTimeInterface
    {
        return $this->dataUpdatedAt;
    }

    public function setDataUpdatedAt(?\DateTimeInterface $dataUpdatedAt): static
    {
        $this->dataUpdatedAt = $dataUpdatedAt;

        return $this;
    }

    public function getDataProvider(): ?string
    {
        return $this->dataProvider;
    }

    public function setDataProvider(?string $dataProvider): static
    {
        $this->dataProvider = $dataProvider;

        return $this;
    }

    /**
     * @return Collection<int, DataEntry>
     */
    public function getDataEntries(): Collection
    {
        return $this->dataEntries;
    }

    public function addDataEntry(DataEntry $dataEntry): static
    {
        if (!$this->dataEntries->contains($dataEntry)) {
            $this->dataEntries->add($dataEntry);
            $dataEntry->setDataset($this);
        }

        return $this;
    }

    public function removeDataEntry(DataEntry $dataEntry): static
    {
        if ($this->dataEntries->removeElement($dataEntry)) {
            // set the owning side to null (unless already changed)
            if ($dataEntry->getDataset() === $this) {
                $dataEntry->setDataset(null);
            }
        }

        return $this;
    }

    public function getProvider(): ?Provider
    {
        return $this->provider;
    }

    public function setProvider(?Provider $provider): static
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * @return Collection<int, Theme>
     */
    public function getThemes(): Collection
    {
        return $this->themes;
    }

    public function addTheme(Theme $theme): static
    {
        if (!$this->themes->contains($theme)) {
            $this->themes->add($theme);
        }

        return $this;
    }

    public function removeTheme(Theme $theme): static
    {
        $this->themes->removeElement($theme);

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
