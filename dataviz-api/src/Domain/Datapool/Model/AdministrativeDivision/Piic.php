<?php

declare(strict_types=1);

namespace App\Domain\Datapool\Model\AdministrativeDivision;

use App\Domain\Datapool\ValueObject\Piic\PiicCode;
use App\Domain\Datapool\ValueObject\Piic\PiicLabel;
use App\Domain\Datapool\ValueObject\Piic\PiicNature;
use App\Domain\Datapool\ValueObject\Piic\PiicNbMunicipalities;
use App\Domain\Datapool\ValueObject\Piic\PiicYear;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'territoire.epci')]
class Piic
{
    #[ORM\OneToMany(targetEntity: Affiliation::class, mappedBy: 'piic')]
    private Collection $affiliations;

    private ?PiicNbMunicipalities $nbMunicipalities = null;

    public function __construct(
        #[ORM\Embedded(columnPrefix: false)]
        private PiicYear $year,

        #[ORM\Embedded(columnPrefix: false)]
        private PiicCode $code,

        #[ORM\Embedded(columnPrefix: false)]
        private PiicLabel $label,

        #[ORM\Embedded(columnPrefix: false)]
        private PiicNature $nature,

        int $nbMunicipalities = 0,
    ) {
        $this->affiliations = new ArrayCollection();
        $this->nbMunicipalities = new PiicNbMunicipalities($nbMunicipalities);
    }

    public function year(): PiicYear
    {
        return $this->year;
    }

    public function code(): PiicCode
    {
        return $this->code;
    }

    public function label(): PiicLabel
    {
        return $this->label;
    }

    public function nature(): PiicNature
    {
        return $this->nature;
    }

    public function affiliations(): Collection
    {
        return $this->affiliations;
    }

    public function nbMunicipalities(): ?PiicNbMunicipalities
    {
        return $this->nbMunicipalities;
    }
}
