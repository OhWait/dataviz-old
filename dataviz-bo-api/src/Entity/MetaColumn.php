<?php

namespace App\Entity;

use ApiPlatform\Metadata as API;
use App\Enum\Group\DataEntryGroupEnum;
use App\Enum\Group\DatasetGroupEnum;
use App\Enum\MetaColumn\DataTypeEnum;
use App\Repository\MetaColumnRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MetaColumnRepository::class)]
#[API\ApiResource(
    operations: [],
)]
class MetaColumn
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\SequenceGenerator(sequenceName: "meta_column_id_id_seq", allocationSize: 1)]
    #[ORM\Column]
    #[Groups([DataEntryGroupEnum::GET])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(max: 255)]
    #[Groups([DatasetGroupEnum::GET, DataEntryGroupEnum::GET, DataEntryGroupEnum::PATCH])]
    private ?string $columnName = null;

    #[ORM\Column]
    #[Assert\NotNull]
    #[Groups([DatasetGroupEnum::GET, DataEntryGroupEnum::GET, DataEntryGroupEnum::PATCH])]
    private ?bool $nullable = null;

    #[ORM\Column(length: 255)]
    #[Assert\Choice(callback: [DataTypeEnum::class, 'getValues'])]
    #[Groups([DatasetGroupEnum::GET, DataEntryGroupEnum::GET, DataEntryGroupEnum::PATCH])]
    private ?string $dataType = null;

    #[ORM\Column(nullable: true)]
    #[Groups([DatasetGroupEnum::GET, DataEntryGroupEnum::GET, DataEntryGroupEnum::PATCH])]
    private ?int $characterMaximumLength = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 255)]
    #[Groups([DatasetGroupEnum::GET, DataEntryGroupEnum::GET, DataEntryGroupEnum::PATCH])]
    private ?string $label = null;

    #[ORM\ManyToOne(inversedBy: 'metaColumns')]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: 'slug')]
    private ?DataEntry $dataEntry = null;

    /**
     * @var Collection<int, MetaRow>
     */
    #[ORM\OneToMany(mappedBy: 'metaColumn', targetEntity: MetaRow::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid]
    #[Groups([DataEntryGroupEnum::GET, DataEntryGroupEnum::PATCH])]
    private Collection $metaRows;

    public function __construct()
    {
        $this->metaRows = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColumnName(): ?string
    {
        return $this->columnName;
    }

    public function setColumnName(string $columnName): static
    {
        $this->columnName = $columnName;

        return $this;
    }

    public function isNullable(): ?bool
    {
        return $this->nullable;
    }

    public function setNullable(bool $nullable): static
    {
        $this->nullable = $nullable;

        return $this;
    }

    public function getDataType(): ?string
    {
        return $this->dataType;
    }

    public function setDataType(string $dataType): static
    {
        $this->dataType = $dataType;

        return $this;
    }

    public function getCharacterMaximumLength(): ?int
    {
        return $this->characterMaximumLength;
    }

    public function setCharacterMaximumLength(?int $characterMaximumLength): static
    {
        $this->characterMaximumLength = $characterMaximumLength;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getDataEntry(): ?DataEntry
    {
        return $this->dataEntry;
    }

    public function setDataEntry(?DataEntry $dataEntry): static
    {
        $this->dataEntry = $dataEntry;

        return $this;
    }

    /**
     * @return Collection<int, MetaRow>
     */
    public function getMetaRows(): Collection
    {
        return $this->metaRows;
    }

    public function addMetaRow(MetaRow $metaRow): static
    {
        if (!$this->metaRows->contains($metaRow)) {
            $this->metaRows->add($metaRow);
            $metaRow->setMetaColumn($this);
        }

        return $this;
    }

    public function removeMetaRow(MetaRow $metaRow): static
    {
        if ($this->metaRows->removeElement($metaRow)) {
            // set the owning side to null (unless already changed)
            if ($metaRow->getMetaColumn() === $this) {
                $metaRow->setMetaColumn(null);
            }
        }

        return $this;
    }
}
