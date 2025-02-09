<?php

namespace App\Entity;

use ApiPlatform\Metadata as API;
use App\Enum\Group\DatasetGroupEnum;
use App\Enum\Group\ThemeGroupEnum;
use App\Repository\ThemeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ThemeRepository::class)]
#[ORM\Table('theme')]
#[API\ApiResource(
    shortName: 'Theme',
    operations: [
        new API\GetCollection(
            normalizationContext: [
                'groups' => [ThemeGroupEnum::GET_COLLECTION],
            ],
        ),

        new API\Get(
            normalizationContext: [
                'groups' => [
                    ThemeGroupEnum::GET_COLLECTION, 
                    ThemeGroupEnum::GET,
                ],
            ],
        ),

        new API\Post(
            denormalizationContext: [
                'groups' => [
                    ThemeGroupEnum::POST,
                    ThemeGroupEnum::PATCH,
                ],
            ],
            normalizationContext: [
                'groups' => [
                    ThemeGroupEnum::GET_COLLECTION,
                    ThemeGroupEnum::GET,
                ],
            ],
        ),

        new API\Patch(
            denormalizationContext: [
                'groups' => [ThemeGroupEnum::PATCH],
            ],
            normalizationContext: [
                'groups' => [
                    ThemeGroupEnum::GET_COLLECTION,
                    ThemeGroupEnum::GET,
                ],
            ],
        ),

        new API\Delete(),
    ],
)]
class Theme
{
    /** @var Collection<int, Dataset> */
    #[ORM\ManyToMany(targetEntity: Dataset::class, mappedBy: 'themes')]
    #[Groups([ThemeGroupEnum::GET])]
    private Collection $datasets;

    public function __construct(
        #[ORM\Id]
        #[ORM\Column(length: 255)]
        #[API\ApiProperty(identifier: true, writable: true, readable: true, required: true)]
        #[Assert\NotBlank()]
        #[Groups([ThemeGroupEnum::GET_COLLECTION, ThemeGroupEnum::POST, DatasetGroupEnum::GET_COLLECTION])]
        private ?string $slug = null,

        #[ORM\Column(length: 255)]
        #[Assert\NotBlank()]
        #[Groups([ThemeGroupEnum::GET_COLLECTION, ThemeGroupEnum::PATCH, DatasetGroupEnum::GET_COLLECTION])]
        private ?string $title = null,

        array $datasets = [],
    )
    {
        $this->datasets = new ArrayCollection($datasets);
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

    /**
     * @return Collection<int, Dataset>
     */
    public function getDatasets(): Collection
    {
        return $this->datasets;
    }

    public function addDataset(Dataset $dataset): static
    {
        if (!$this->datasets->contains($dataset)) {
            $this->datasets->add($dataset);
            $dataset->addTheme($this);
        }

        return $this;
    }

    public function removeDataset(Dataset $dataset): static
    {
        if ($this->datasets->removeElement($dataset)) {
            $dataset->removeTheme($this);
        }

        return $this;
    }
}
