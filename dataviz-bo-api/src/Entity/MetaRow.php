<?php

namespace App\Entity;

use ApiPlatform\Metadata as API;
use App\Enum\Group\DataEntryGroupEnum;
use App\Enum\Group\DatasetGroupEnum;
use App\Repository\MetaRowRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MetaRowRepository::class)]
#[ORM\Table('meta_row')]
#[API\ApiResource(
    operations: [],
)]
class MetaRow
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[Groups([DataEntryGroupEnum::GET])]
    private ?Uuid $id = null;

    public function __construct(
        #[ORM\Column(length: 255)]
        #[Assert\NotBlank]
        #[Assert\NotNull]
        #[Assert\Length(max: 255)]
        #[Groups([DataEntryGroupEnum::GET, DataEntryGroupEnum::PATCH])]
        private ?string $value = null,

        #[ORM\Column(length: 255, nullable: true)]
        #[Assert\NotBlank(allowNull: true)]
        #[Assert\Length(max: 255)]
        #[Groups([DatasetGroupEnum::GET, DataEntryGroupEnum::GET, DataEntryGroupEnum::PATCH])]
        private ?string $label = null,

        #[ORM\ManyToOne(inversedBy: 'metaRows')]
        #[ORM\JoinColumn(nullable: false)]
        private ?MetaColumn $metaColumn = null,
    ) {
        $this->id = Uuid::v4();
    }

    public function getId(): ?Uuid
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
