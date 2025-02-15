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
#[ORM\Table(name: 'data_entry')]
#[ORM\UniqueConstraint(
    name: 'schema_table_unique_idx',
    columns: ['schema_name', 'table_name'],
)]
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
            denormalizationContext: [
                'groups' => [
                    DataEntryGroupEnum::POST,
                    DataEntryGroupEnum::PATCH,
                ],
            ],
            normalizationContext: [
                'groups' => [
                    DataEntryGroupEnum::GET_COLLECTION,
                    DataEntryGroupEnum::GET,
                ],
            ],
        ),

        new API\Patch(
            denormalizationContext: [
                'groups' => [DataEntryGroupEnum::PATCH],
            ],
            normalizationContext: [
                'groups' => [
                    DataEntryGroupEnum::GET_COLLECTION,
                    DataEntryGroupEnum::GET,
                ],
            ],
        ),

        new API\Delete(),
    ],
)]
class DataEntry
{
    /** @var Collection<int, MetaColumn> */
    #[ORM\OneToMany(mappedBy: 'dataEntry', targetEntity: MetaColumn::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid]
    #[Groups([DatasetGroupEnum::GET, DataEntryGroupEnum::GET, DataEntryGroupEnum::PATCH])]
    private Collection $metaColumns;

    #[ORM\Column]
    #[Groups([DataEntryGroupEnum::GET])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups([DataEntryGroupEnum::GET])]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct(
        #[ORM\Id]
        #[ORM\Column(length: 255, unique: true)]
        #[API\ApiProperty(identifier: true, readable: true, writable: true, required: true)]
        #[Assert\NotBlank]
        #[Assert\NotNull]
        #[Assert\Length(max: 255)]
        #[Groups([DatasetGroupEnum::GET, DataEntryGroupEnum::GET_COLLECTION, DataEntryGroupEnum::POST])]
        private $slug = null,

        #[ORM\Column(length: 255)]
        #[Assert\NotBlank]
        #[Assert\NotNull]
        #[Assert\Length(max: 255)]
        #[Groups([DatasetGroupEnum::GET, DataEntryGroupEnum::GET_COLLECTION, DataEntryGroupEnum::PATCH])]
        private $title = null,

        #[ORM\Column(length: 255)]
        #[Assert\NotBlank]
        #[Assert\NotNull]
        #[Assert\Length(max: 255)]
        #[Groups([DataEntryGroupEnum::GET_COLLECTION, DataEntryGroupEnum::PATCH])]
        private $schemaName = null,

        #[ORM\Column(length: 255)]
        #[Assert\NotBlank]
        #[Assert\NotNull]
        #[Assert\Length(max: 255)]
        #[Groups([DataEntryGroupEnum::GET_COLLECTION, DataEntryGroupEnum::PATCH])]
        private $tableName = null,

        #[ORM\ManyToOne(targetEntity: Dataset::class, inversedBy: 'dataEntries')]
        #[ORM\JoinColumn(nullable: false, referencedColumnName: 'slug')]
        #[Assert\NotBlank()]
        #[Assert\NotNull]
        #[Groups([DataEntryGroupEnum::GET_COLLECTION, DataEntryGroupEnum::PATCH])]
        private $dataset = null,

        $metaColumns = [],
    )
    {
        $this->metaColumns = new ArrayCollection();

        // TODO: why doesnt it work without this ?
        foreach ($metaColumns as $metaColumn) {
            $this->addMetaColumn($metaColumn);
        }

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

    public function setTitle(?string $title): static
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
