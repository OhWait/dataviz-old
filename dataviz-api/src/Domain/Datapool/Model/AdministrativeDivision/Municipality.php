<?php

declare(strict_types=1);

namespace App\Domain\Datapool\Model\AdministrativeDivision;

use App\Domain\Datapool\ValueObject\Municipality\MunicipalityCodgeo;
use App\Domain\Datapool\ValueObject\Municipality\MunicipalityLabel;
use App\Domain\Datapool\ValueObject\Municipality\MunicipalityYear;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'territoire.commune')]
class Municipality
{
    #[ORM\OneToOne(mappedBy: 'municipality', targetEntity: Affiliation::class)]
    private Affiliation $affiliation;

    public function __construct(
        #[ORM\Embedded(columnPrefix: false)]
        private MunicipalityYear $year,

        #[ORM\Column(length: 3)]
        public string $typecom,

        #[ORM\Embedded(columnPrefix: false)]
        private MunicipalityCodgeo $codgeo,

        #[ORM\Column(length: 2, nullable: true)]
        public ?string $reg,

        #[ORM\Column(length: 3, nullable: true)]
        public ?string $dep,

        #[ORM\Column(length: 4, nullable: true)]
        public ?string $ctcd,

        #[ORM\Column(length: 4, nullable: true)]
        public ?string $arr,

        #[ORM\Column(length: 1, nullable: true)]
        public ?string $tncc,

        #[ORM\Column(length: 255)]
        public string $ncc,

        #[ORM\Column(length: 255)]
        public string $nccenr,

        #[ORM\Embedded(columnPrefix: false)]
        private MunicipalityLabel $label,

        #[ORM\Column(length: 5, nullable: true)]
        public ?string $can,

        #[ORM\Column(length: 5, nullable: true)]
        public ?string $comparent,
    ) {
        $this->affiliation = new Affiliation($year->value, $codgeo->value);
    }

    public function year(): MunicipalityYear
    {
        return $this->year;
    }

    public function codgeo(): MunicipalityCodgeo
    {
        return $this->codgeo;
    }

    public function label(): MunicipalityLabel
    {
        return $this->label;
    }

    public function piic(): Piic
    {
        return $this->affiliation->piic();
    }

    public function department(): Department
    {
        return $this->affiliation->department();
    }
}
