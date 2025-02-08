<?php

namespace App\Entity;

use ApiPlatform\Metadata as API;
use App\Enum\Group\DataEntryGroupEnum;
use App\Enum\Group\DatasetGroupEnum;
use App\Repository\DataEntryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DataEntryRepository::class)]
#[API\ApiResource(
    operations: [
        new API\GetCollection(
            normalizationContext: [
                'groups' => [DataEntryGroupEnum::GET_COLLECTION],
            ],
        ),

        new API\Get(
            normalizationContext: [
                'groups' => [
                    DataEntryGroupEnum::GET_COLLECTION,
                    DataEntryGroupEnum::GET,
                ],
            ],
        ),

        new API\Post(
            normalizationContext: [
                'groups' => [
                    DataEntryGroupEnum::GET_COLLECTION,
                    DataEntryGroupEnum::GET,
                ],
            ],
        ),

        new API\Post(
            validationContext: [
                'groups' => [DataEntryGroupEnum::POST],
            ],
            denormalizationContext: [
                'groups' => [DataEntryGroupEnum::POST],
            ],
            normalizationContext: [
                'groups' => [DataEntryGroupEnum::POST],
            ],
        ),

        new API\Patch(
            validationContext: [
                'groups' => [DataEntryGroupEnum::PATCH],
            ],
            denormalizationContext: [
                'groups' => [DataEntryGroupEnum::PATCH],
            ],
            normalizationContext: [
                'groups' => [DataEntryGroupEnum::PATCH],
            ],
        ),

        new API\Delete(),
    ]
)]
class DataEntry
{
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
        Assert\NotBlank(groups: [DataEntryGroupEnum::POST]),
        Assert\Length(max: 255, groups: [DataEntryGroupEnum::POST]),
        Assert\Type('string', groups: [DataEntryGroupEnum::POST]),
        Groups([
            DataEntryGroupEnum::GET_COLLECTION,
            DataEntryGroupEnum::POST,
            DataEntryGroupEnum::PATCH,
            DatasetGroupEnum::GET,
        ]),
    ]
    private ?string $slug = null;

    #[
        ORM\Column(length: 255),
        API\ApiProperty(openapiContext: [
            'type' => 'string',
            'maxLength' => 255,
        ]),
        Assert\NotBlank(groups: [
            DataEntryGroupEnum::POST, 
            DataEntryGroupEnum::PATCH,
        ]),
        Groups([
            DataEntryGroupEnum::GET_COLLECTION,
            DataEntryGroupEnum::POST,
            DataEntryGroupEnum::PATCH,
            DatasetGroupEnum::GET,
        ]),
    ]
    private ?string $title = null;

    #[
        ORM\Column(length: 255),
        API\ApiProperty(openapiContext: [
            'type' => 'string',
            'maxLength' => 255,
        ]),
        Assert\NotBlank(groups: [
            DataEntryGroupEnum::POST, 
            DataEntryGroupEnum::PATCH,
        ]),
        Groups([
            DataEntryGroupEnum::GET_COLLECTION,
            DataEntryGroupEnum::POST,
            DataEntryGroupEnum::PATCH,
        ]),
    ]
    private ?string $schemaName = null;

    #[
        ORM\Column(length: 255),
        API\ApiProperty(openapiContext: [
            'type' => 'string',
            'maxLength' => 255,
        ]),
        Assert\NotBlank(groups: [
            DataEntryGroupEnum::POST,
            DataEntryGroupEnum::PATCH,
        ]),
        Groups([
            DataEntryGroupEnum::GET_COLLECTION,
            DataEntryGroupEnum::POST,
            DataEntryGroupEnum::PATCH,
        ]),
    ]
    private ?string $tableName = null;

    /**
     * @var Collection<int, MetaColumn>
     */
    #[
        ORM\OneToMany(
            mappedBy: 'dataEntry',
            targetEntity: MetaColumn::class,
            orphanRemoval: true
        ),
        Groups([
            DataEntryGroupEnum::GET,
            DatasetGroupEnum::GET,
        ])
    ]
    private Collection $metaColumns;

    #[
        ORM\JoinColumn(nullable: false, referencedColumnName: 'slug'),
        ORM\ManyToOne(inversedBy: 'dataEntries'),
        Assert\NotBlank(groups: [DataEntryGroupEnum::POST]),
        Groups([DataEntryGroupEnum::POST]),
    ]
    private ?Dataset $dataset = null;

    #[
        ORM\Column,
        API\ApiProperty(
            openapiContext: [
                'type' => 'string',
                'format' => 'date',
            ],
        ),
        Groups([DataEntryGroupEnum::GET]),
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
        Groups([DataEntryGroupEnum::GET]),
    ]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
        $this->metaColumns = new ArrayCollection();
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

    public function getSchemaName(): ?string
    {
        return $this->schemaName;
    }

    public function setSchemaName(string $schemaName): static
    {
        $this->schemaName = $schemaName;

        return $this;
    }

    public function getTableName(): ?string
    {
        return $this->tableName;
    }

    public function setTableName(string $tableName): static
    {
        $this->tableName = $tableName;

        return $this;
    }

    /**
     * @return Collection<int, MetaColumn>
     */
    public function getMetaColumns(): Collection
    {
        return $this->metaColumns;
    }

    public function addMetaColumn(MetaColumn $metaColumn): static
    {
        if (!$this->metaColumns->contains($metaColumn)) {
            $this->metaColumns->add($metaColumn);
            $metaColumn->setDataEntry($this);
        }

        return $this;
    }

    public function removeMetaColumn(MetaColumn $metaColumn): static
    {
        if ($this->metaColumns->removeElement($metaColumn)) {
            // set the owning side to null (unless already changed)
            if ($metaColumn->getDataEntry() === $this) {
                $metaColumn->setDataEntry(null);
            }
        }

        return $this;
    }

    public function getDataset(): ?Dataset
    {
        return $this->dataset;
    }

    public function setDataset(?Dataset $dataset): static
    {
        $this->dataset = $dataset;

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
