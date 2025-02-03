<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\ValueObject\Provider\ProviderAcronym;
use App\Domain\ValueObject\Provider\ProviderCreatedAt;
use App\Domain\ValueObject\Provider\ProviderDescription;
use App\Domain\ValueObject\Provider\ProviderImage;
use App\Domain\ValueObject\Provider\ProviderName;
use App\Domain\ValueObject\Provider\ProviderSlug;
use App\Domain\ValueObject\Provider\ProviderUpdatedAt;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity]
#[ORM\Table('provider')]
#[Vich\Uploadable]
class Provider
{
    #[ORM\Embedded(columnPrefix: false)]
    private ProviderImage $image;

    #[Vich\UploadableField(mapping: 'provider_image', fileNameProperty: 'image.value')]
    private ?File $imageFile = null;

    /** @var Collection<int, Dataset> */
    #[ORM\OneToMany(mappedBy: 'provider', targetEntity: Dataset::class, orphanRemoval: true)]
    private Collection $datasets;

    #[ORM\Embedded(columnPrefix: false)]
    private ProviderCreatedAt $createdAt;

    #[ORM\Embedded(columnPrefix: false)]
    private ProviderUpdatedAt $updatedAt;

    public function __construct(
        #[ORM\Embedded(columnPrefix: false)]
        private ProviderSlug $slug,

        #[ORM\Embedded(columnPrefix: false)]
        private ProviderName $name,

        #[ORM\Embedded(columnPrefix: false)]
        private ProviderAcronym $acronym,

        #[ORM\Embedded(columnPrefix: false)]
        private ProviderDescription $description,
    ) {
        $this->createdAt = new ProviderCreatedAt();
        $this->updatedAt = new ProviderUpdatedAt();
        $this->datasets = new ArrayCollection();
        $this->image = new ProviderImage();
    }

    public function update(
        ?ProviderName $name,
        ?ProviderAcronym $acronym,
        ?ProviderDescription $description,
    ): void {
        $this->name = $name ?? $this->name;
        $this->acronym = $acronym ?? $this->acronym;
        $this->description = $description ?? $this->description;
        $this->updatedAt = new ProviderUpdatedAt();
    }

    public function setImageFile(File $imageFile): void
    {
        $this->imageFile = $imageFile;
        $this->updatedAt = new ProviderUpdatedAt();
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function slug(): ProviderSlug
    {
        return $this->slug;
    }

    public function name(): ProviderName
    {
        return $this->name;
    }

    public function acronym(): ProviderAcronym
    {
        return $this->acronym;
    }

    public function description(): ProviderDescription
    {
        return $this->description;
    }

    public function createdAt(): ProviderCreatedAt
    {
        return $this->createdAt;
    }

    public function updatedAt(): ProviderUpdatedAt
    {
        return $this->updatedAt;
    }

    /**
     * @return Collection<int, Dataset>
     */
    public function datasets(): Collection
    {
        return $this->datasets;
    }

    public function image(): ProviderImage
    {
        return $this->image;
    }
}
