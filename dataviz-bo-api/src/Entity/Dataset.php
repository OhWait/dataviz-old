<?php

namespace App\Entity;

use ApiPlatform\Metadata as API;
use App\Enum\Dataset\DataProviderEnum;
use App\Enum\Dataset\FrequencyEnum;
use App\Enum\Dataset\GranularityEnum;
use App\Enum\Dataset\LanguageEnum;
use App\Enum\Dataset\OrderByEnum;
use App\Enum\Dataset\SecurityEnum;
use App\Enum\Group\DatasetGroupEnum;
use App\Repository\DatasetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DatasetRepository::class)]
#[API\ApiResource(
    operations: [
        new API\GetCollection(
            normalizationContext: ['groups' => [DatasetGroupEnum::GET_COLLECTION]],
            openapiContext: [
                'parameters' => [
                    [
                        'in' => 'query',
                        'name' => 'dataProvider',
                        'schema' => ['type' => 'boolean'],
                        'required' => false,
                    ],
                    [
                        'in' => 'query',
                        'name' => 'themes',
                        'schema' => [
                            'type' => 'array',
                            'items' => ['type' => 'string'],
                        ],
                        'explode' => true,
                        'required' => false,
                    ],
                    [
                        'in' => 'query',
                        'name' => 'orderBy',
                        'schema' => [
                            'type' => 'string',
                            'enum' => self::ORDER_BY,
                        ],
                        'required' => false,
                    ],
                ],
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
            validationContext: [
                'groups' => [
                    DatasetGroupEnum::POST,
                    DatasetGroupEnum::PATCH,
                ],
            ],
            denormalizationContext: [
                'groups' => [
                    DatasetGroupEnum::POST, 
                    DatasetGroupEnum::PATCH,
                ],
            ],
            normalizationContext: [
                'groups' => [
                    DatasetGroupEnum::GET_COLLECTION, 
                    DatasetGroupEnum::GET,
                ],
            ],
        ),

        new API\Patch(
            validationContext: ['groups' => [DatasetGroupEnum::PATCH]],
            denormalizationContext: ['groups' => [DatasetGroupEnum::PATCH]],
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
    /**
     * @var string[] ORDER_BY
     */
    public const ORDER_BY = [
        OrderByEnum::DATA_UPDATED_AT->value,
        OrderByEnum::CATEGORY->value,
    ];

    /**
     * @var string[] GRANULARITY
     */
    public const GRANULARITY = [
        GranularityEnum::POI->value,
        GranularityEnum::MUNICIPALITIE->value,
        GranularityEnum::PIIC->value,
        GranularityEnum::DEPARTMENT->value,
        GranularityEnum::COUNTRY->value,
        GranularityEnum::OTHER->value,
    ];

    /**
     * @var string[] FREQUENCY
     */
    public const FREQUENCY = [
        FrequencyEnum::DAILY->value,
        FrequencyEnum::WEEKLY->value,
        FrequencyEnum::MONTHLY->value,
        FrequencyEnum::QUARTERLY->value,
        FrequencyEnum::HALF_YEARLY->value,
        FrequencyEnum::YEARLY->value,
    ];

    /**
     * @var string[] LANGUAGE
     */
    public const LANGUAGE = [
        LanguageEnum::FR->value,
        LanguageEnum::EN->value,
    ];

    /**
     * @var string[] SECURITY
     */
    public const SECURITY = [
        SecurityEnum::PUBLIC->value,
        SecurityEnum::PRENIUM->value,
    ];

    /**
     * @var string[] DATA_PROVIDER
     */
    public const DATA_PROVIDER = [
        DataProviderEnum::ACCIDENTOLOGY->value,
        DataProviderEnum::INSEE_TD->value,
    ];

    #[
        ORM\Id,
        ORM\Column(
            length: 255,
            unique: true,
        ),
        API\ApiProperty(
            identifier: true,
            readable: true,
            writable: true,
            openapiContext: ['type' => 'string', 'maxLength' => 255],
            required: true,
        ),
        Assert\NotBlank(groups: [DatasetGroupEnum::POST]),
        Assert\Length(max: 255, groups: [DatasetGroupEnum::POST]),
        Assert\Type('string', groups: [DatasetGroupEnum::POST]),
        Groups([
            DatasetGroupEnum::GET_COLLECTION,
            DatasetGroupEnum::POST,
        ]),
    ]
    private ?string $slug = null;

    #[
        ORM\Column(length: 255),
        API\ApiProperty(
            openapiContext: ['type' => 'string', 'maxLength' => 255],
            required: true,
        ),
        Assert\NotBlank(groups: [DatasetGroupEnum::PATCH]),
        Assert\Length(max: 255, groups: [DatasetGroupEnum::PATCH]),
        Assert\Type('string', groups: [DatasetGroupEnum::PATCH]),
        Groups([
            DatasetGroupEnum::GET_COLLECTION,
            DatasetGroupEnum::PATCH,
        ]),
    ]
    private ?string $title = null;

    #[
        ORM\Column(length: 255, nullable: true),
        API\ApiProperty(openapiContext: ['type' => 'string', 'maxLength' => 255]),
        Assert\Length(max: 255, groups: [DatasetGroupEnum::PATCH]),
        Groups([
            DatasetGroupEnum::GET_COLLECTION,
            DatasetGroupEnum::POST,
            DatasetGroupEnum::PATCH,
        ]),
    ]
    private ?string $shortTitle = null;

    #[
        ORM\Column(type: Types::TEXT, nullable: true),
        API\ApiProperty(openapiContext: ['type' => 'string', 'nullable' => true]),
        Assert\NotBlank(allowNull: true, groups: [DatasetGroupEnum::PATCH]),
        Groups([
            DatasetGroupEnum::GET,
            DatasetGroupEnum::PATCH,
        ]),
    ]
    private ?string $description = null;

    #[
        ORM\Column(type: Types::TEXT),
        API\ApiProperty(
            openapiContext: ['type' => 'string', 'maxLength' => 255],
            required: true,
        ),
        Assert\NotBlank(groups: [DatasetGroupEnum::PATCH]),
        Assert\Length(max: 255, groups: [DatasetGroupEnum::PATCH]),
        Assert\Type('string', groups: [DatasetGroupEnum::PATCH]),
        Groups([
            DatasetGroupEnum::GET_COLLECTION,
            DatasetGroupEnum::PATCH,
        ]),
    ]
    private ?string $perimeter = null;

    #[
        ORM\Column(length: 255),
        API\ApiProperty(
            openapiContext: [
                'type' => 'string',
                'enum' => self::GRANULARITY,
            ],
            required: true,
        ),
        Assert\NotBlank(groups: [DatasetGroupEnum::PATCH]),
        Assert\Choice(choices: self::GRANULARITY, groups: [DatasetGroupEnum::PATCH]),
        Groups([
            DatasetGroupEnum::GET_COLLECTION,
            DatasetGroupEnum::PATCH,
        ]),
    ]
    private ?string $granularity = null;

    #[
        ORM\Column(length: 255, nullable: true),
        API\ApiProperty(
            openapiContext: [
                'type' => 'string',
                'nullable' => true,
                'enum' => self::FREQUENCY,
            ],
        ),
        Assert\Choice(choices: self::FREQUENCY, groups: [DatasetGroupEnum::PATCH]),
        Groups([
            DatasetGroupEnum::GET_COLLECTION,
            DatasetGroupEnum::PATCH,
        ]),
    ]
    private ?string $updateFrequency = null;

    #[
        ORM\Column(length: 255, nullable: true),
        API\ApiProperty(
            openapiContext: [
                'type' => 'string',
                'maxLength' => 255,
                'nullable' => true,
            ],
        ),
        Assert\NotBlank(allowNull: true, groups: [DatasetGroupEnum::PATCH]),
        Assert\Length(max: 255, groups: [DatasetGroupEnum::PATCH]),
        Groups([
            DatasetGroupEnum::GET_COLLECTION,
            DatasetGroupEnum::PATCH,
        ]),
    ]
    private ?string $updatePeriod = null;

    #[
        ORM\Column(length: 255),
        API\ApiProperty(
            openapiContext: ['type' => 'string', 'enum' => self::SECURITY],
            required: true,
        ),
        Assert\NotBlank(groups: [DatasetGroupEnum::PATCH]),
        Assert\Choice(choices: self::SECURITY, groups: [DatasetGroupEnum::PATCH]),
        Groups([DatasetGroupEnum::PATCH]),
    ]
    private ?string $security = null;

    #[
        ORM\Column(length: 255, nullable: true),
        API\ApiProperty(
            openapiContext: [
                'type' => 'string',
                'nullable' => true,
                'enum' => self::LANGUAGE,
            ],
        ),
        Assert\Choice(choices: self::LANGUAGE, groups: [DatasetGroupEnum::PATCH]),
        Groups([
            DatasetGroupEnum::GET_COLLECTION,
            DatasetGroupEnum::PATCH,
        ]),
    ]
    private ?string $language = null;

    #[
        ORM\Column(nullable: true),
        API\ApiProperty(
            openapiContext: [
                'type' => 'string',
                'format' => 'date',
                'nullable' => true,
            ],
        ),
        Groups([
            DatasetGroupEnum::GET_COLLECTION,
            DatasetGroupEnum::PATCH,
        ]),
    ]
    private ?\DateTimeImmutable $dataCreatedAt = null;

    #[
        ORM\Column(nullable: true),
        API\ApiProperty(
            openapiContext: [
                'type' => 'string',
                'format' => 'date',
                'nullable' => true,
            ],
        ),
        Groups([
            DatasetGroupEnum::GET_COLLECTION,
            DatasetGroupEnum::PATCH,
        ]),
    ]
    private ?\DateTimeImmutable $dataUpdatedAt = null;

    #[
        ORM\Column(length: 255, nullable: true),
        API\ApiProperty(
            openapiContext: [
                'type' => 'string',
                'nullable' => true,
            ],
        ),
        Assert\Choice(choices: self::DATA_PROVIDER, groups: [DatasetGroupEnum::PATCH]),
        Groups([DatasetGroupEnum::PATCH]),
    ]
    private ?string $dataProvider = null;


    #[
        ORM\JoinColumn(nullable: false, referencedColumnName: 'slug'),
        ORM\ManyToOne(inversedBy: 'datasets'),
        Assert\NotBlank(groups: [DatasetGroupEnum::POST]),
        Groups([
            DatasetGroupEnum::GET_COLLECTION,
            DatasetGroupEnum::PATCH,
        ]),
    ]
    private ?Provider $provider = null;

    /**
     * @var Collection<int, Theme>
     */
    #[
        ORM\JoinTable(name: 'theme_dataset'),
        ORM\JoinColumn(name: 'dataset', referencedColumnName: 'slug'),
        ORM\InverseJoinColumn(name: 'theme', referencedColumnName: 'slug'),
        ORM\ManyToMany(
            targetEntity: Theme::class,
            inversedBy: 'datasets',
            cascade: ['persist'],
        ),
        Assert\NotBlank(groups: [DatasetGroupEnum::POST]),
        Assert\Count(min: 1, groups: [DatasetGroupEnum::POST]),
        Assert\Type('array', groups: [DatasetGroupEnum::PATCH]),
        Groups([
            DatasetGroupEnum::GET_COLLECTION,
            DatasetGroupEnum::PATCH,
        ]),
    ]
    private Collection $themes;

    /**
     * @var Collection<int, DataEntry>
     */
    #[
        ORM\OneToMany(
            mappedBy: 'dataset', 
            targetEntity: DataEntry::class, 
            orphanRemoval: true
        ),
        Groups([DatasetGroupEnum::GET]),
    ]
    private Collection $dataEntries;

    #[
        ORM\Column,
        API\ApiProperty(
            openapiContext: [
                'type' => 'string',
                'format' => 'date',
            ],
        ),
        Groups([DatasetGroupEnum::GET]),
    ]
    private ?\DateTimeImmutable $createdAt = null;

    #[
        ORM\Column,
        API\ApiProperty(
            openapiContext: [
                'type' => 'string',
                'format' => 'date',
            ],
        ),
        Groups([DatasetGroupEnum::GET]),
    ]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
        $this->dataEntries = new ArrayCollection();
        $this->themes = new ArrayCollection();
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

    public function getDataCreatedAt(): ?\DateTimeImmutable
    {
        return $this->dataCreatedAt;
    }

    public function setDataCreatedAt(?\DateTimeImmutable $dataCreatedAt): static
    {
        $this->dataCreatedAt = $dataCreatedAt;

        return $this;
    }

    public function getDataUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->dataUpdatedAt;
    }

    public function setDataUpdatedAt(?\DateTimeImmutable $dataUpdatedAt): static
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
