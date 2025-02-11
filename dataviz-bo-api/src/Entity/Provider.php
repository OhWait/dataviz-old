<?php

namespace App\Entity;

use ApiPlatform\Metadata as API;
use ApiPlatform\OpenApi\Model;
use App\Enum\Group\DatasetGroupEnum;
use App\Enum\Group\ProviderGroupEnum;
use App\Repository\ProviderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ProviderRepository::class)]
#[Vich\Uploadable]
#[API\ApiResource(
    shortName: 'Provider',
    operations: [
        new API\GetCollection(
            normalizationContext: [
                'groups' => [ProviderGroupEnum::GET_COLLECTION],
            ],
        ),

        new API\Get(
            normalizationContext: [
                'groups' => [
                    ProviderGroupEnum::GET_COLLECTION,
                    ProviderGroupEnum::GET
                ],
            ],
        ),

        new API\Post(
            denormalizationContext: [
                'groups' => [
                    ProviderGroupEnum::POST,
                    ProviderGroupEnum::PATCH,
                ],
            ],
            normalizationContext: [
                'groups' => [
                    ProviderGroupEnum::GET_COLLECTION,
                    ProviderGroupEnum::GET,
                ],
            ],
        ),

        new API\Post(
            uriTemplate: '/provider/{slug}/upload-logo',
            inputFormats: ['multipart' => ['multipart/form-data']],
            openapi: new Model\Operation(
                summary: 'Add or replace the provider logo',
                description: 'Add or replace the provider logo',
                requestBody: new Model\RequestBody(
                    content: new \ArrayObject([
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object', 
                                'properties' => [
                                    'file' => [
                                        'type' => 'string', 
                                        'format' => 'binary'
                                    ]
                                ]
                            ]
                        ]
                    ])
                )
            ),
            denormalizationContext: [
                'groups' => [ProviderGroupEnum::POST_IMAGE],
            ],
            normalizationContext: [
                'groups' => [ProviderGroupEnum::GET_COLLECTION],
            ],
        ),

        new API\Patch(
            denormalizationContext: [
                'groups' => [ProviderGroupEnum::PATCH],
            ],
            normalizationContext: [
                'groups' => [ProviderGroupEnum::GET_COLLECTION, ProviderGroupEnum::GET],
            ],
        ),

        new API\Delete(),
    ],
)]
class Provider
{
    #[ORM\Id]
    #[ORM\Column(length: 255)]
    #[API\ApiProperty(identifier: true, writable: true, readable: true, required: true)]
    #[Assert\NotBlank()]
    #[Assert\Length(max: 255)]
    #[Groups([ProviderGroupEnum::GET_COLLECTION, ProviderGroupEnum::POST, ProviderGroupEnum::POST_IMAGE, DatasetGroupEnum::GET_COLLECTION])]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(max: 255)]
    #[Groups([ProviderGroupEnum::GET_COLLECTION, ProviderGroupEnum::PATCH, DatasetGroupEnum::GET_COLLECTION])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(options: ['allowNull' => true])]
    #[Assert\Length(max: 255)]
    #[Groups([ProviderGroupEnum::GET_COLLECTION, ProviderGroupEnum::PATCH, DatasetGroupEnum::GET_COLLECTION])]
    private ?string $acronym = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotBlank(options: ['allowNull' => true])]
    #[Groups([ProviderGroupEnum::GET, ProviderGroupEnum::PATCH, DatasetGroupEnum::GET])]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[API\ApiProperty(writable: false)]
    private ?string $image = null;

    #[Vich\UploadableField(mapping: 'provider_image', fileNameProperty: 'image')]
    #[Groups([ProviderGroupEnum::POST_IMAGE])]
    private ?File $file = null;

    #[API\ApiProperty(types: ['https://schema.org/contentUrl'], writable: false)]
    #[Groups([ProviderGroupEnum::GET_COLLECTION])]
    private ?string $contentUrl = null;

    /**
     * @var Collection<int, Dataset>
     */
    #[ORM\OneToMany(mappedBy: 'provider', targetEntity: Dataset::class, orphanRemoval: true)]
    #[Groups([ProviderGroupEnum::GET])]
    private Collection $datasets;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->datasets = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAcronym(): ?string
    {
        return $this->acronym;
    }

    public function setAcronym(?string $acronym): static
    {
        $this->acronym = $acronym;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(File $file): static
    {
        $this->file = $file;
        $this->updatedAt = new \DateTimeImmutable();

        return $this;
    }

    public function getContentUrl(): ?string
    {
        return $this->contentUrl;
    }

    public function setContentUrl(?string $contentUrl): static
    {
        $this->contentUrl = $contentUrl;

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
            $dataset->setProvider($this);
        }

        return $this;
    }

    public function removeDataset(Dataset $dataset): static
    {
        if ($this->datasets->removeElement($dataset)) {
            // set the owning side to null (unless already changed)
            if ($dataset->getProvider() === $this) {
                $dataset->setProvider(null);
            }
        }

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
