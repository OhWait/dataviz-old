<?php

namespace App\Entity;

use ApiPlatform\Metadata as API;
use App\Enum\Group\DataEntryGroupEnum;
use App\Enum\Group\DatasetGroupEnum;
use App\Repository\MetaRowRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MetaRowRepository::class)]
#[API\ApiResource(
    operations: [],
)]
class MetaRow
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\SequenceGenerator(sequenceName: "meta_row_id_id_seq", allocationSize: 1)]
    #[ORM\Column]
    #[Groups([DataEntryGroupEnum::GET])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(max: 255)]
    #[Groups([DataEntryGroupEnum::GET, DataEntryGroupEnum::PATCH])]
    private ?string $value = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 255)]
    #[Groups([DatasetGroupEnum::GET, DataEntryGroupEnum::GET, DataEntryGroupEnum::PATCH])]
    private ?string $label = null;

    #[ORM\ManyToOne(inversedBy: 'metaRows')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MetaColumn $metaColumn = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getMetaColumn(): ?MetaColumn
    {
        return $this->metaColumn;
    }

    public function setMetaColumn(?MetaColumn $metaColumn): static
    {
        $this->metaColumn = $metaColumn;

        return $this;
    }
}
