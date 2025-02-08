<?php

namespace App\Entity;

use ApiPlatform\Metadata as API;
use App\Enum\Group\DataEntryGroupEnum;
use App\Enum\Group\DatasetGroupEnum;
use App\Repository\MetaRowRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MetaRowRepository::class)]
#[API\ApiResource(
    operations: [],
)]
class MetaRow
{
    #[
        ORM\Id,
        ORM\GeneratedValue,
        ORM\Column,
    ]
    private ?int $id = null;

    #[
        ORM\Column(length: 255),
        API\ApiProperty(
            identifier: true,
            readable: true,
            openapiContext: [
                'type' => 'string',
                'maxLength' => 255,
            ],
            required: true,
        ),
    ]
    private ?string $value = null;

    #[
        ORM\Column(length: 255, nullable: true),
        Groups([
            DataEntryGroupEnum::GET,
            DatasetGroupEnum::GET,
        ]),
    ]
    private ?string $label = null;

    #[
        ORM\ManyToOne(inversedBy: 'metaRows'),
        ORM\JoinColumn(nullable: false),
    ]
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
