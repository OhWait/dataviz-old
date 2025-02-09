<?php

declare(strict_types=1);

namespace App\Domain\Dataviz\Model;

use App\Domain\Dataviz\ValueObject\Theme\ThemeSlug;
use App\Domain\Dataviz\ValueObject\Theme\ThemeTitle;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table('theme')]
class Theme
{
    /** @var Collection<int, Dataset> */
    #[ORM\ManyToMany(targetEntity: Dataset::class, mappedBy: 'themes')]
    private Collection $datasets;

    public function __construct(
        #[ORM\Embedded(columnPrefix: false)]
        private ThemeSlug $slug,

        #[ORM\Embedded(columnPrefix: false)]
        private ThemeTitle $title,
    ) {
        $this->datasets = new ArrayCollection();
    }

    public function slug(): ThemeSlug
    {
        return $this->slug;
    }

    public function title(): ThemeTitle
    {
        return $this->title;
    }

    /**
     * @return Collection<int, Dataset>
     */
    public function datasets(): Collection
    {
        return $this->datasets;
    }
}
