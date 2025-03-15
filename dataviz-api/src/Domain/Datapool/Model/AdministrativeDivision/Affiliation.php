<?php

declare(strict_types=1);

namespace App\Domain\Datapool\Model\AdministrativeDivision;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "territoire.appartenance")]
#[ApiResource]
class Affiliation
{
    #[ORM\OneToOne(inversedBy: 'affiliation', targetEntity: Municipality::class)]
    #[ORM\JoinColumn(name: 'annee', referencedColumnName: 'annee')]
    #[ORM\JoinColumn(name: 'codgeo', referencedColumnName: 'codgeo')]
    private Municipality $municipality;

    #[ORM\ManyToOne(inversedBy: 'affiliations')]
    #[ORM\JoinColumn(name: 'annee', referencedColumnName: 'annee')]
    #[ORM\JoinColumn(name: 'epci', referencedColumnName: 'epci')]
    private ?Piic $piic = null;

    #[ORM\ManyToOne(inversedBy: 'affiliations')]
    #[ORM\JoinColumn(name: 'annee', referencedColumnName: 'annee')]
    #[ORM\JoinColumn(name: 'dep', referencedColumnName: 'dep')]
    private Department $department;

    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'integer', name: 'annee')]
        private int $year,

        #[ORM\Id]
        #[ORM\Column(type: 'string', length: 5)]
        private string $codgeo,
    ) {
    }

    public function municipality(): Municipality
    {
        return $this->municipality;
    }

    public function piic(): Piic
    {
        return $this->piic;
    }

    public function department(): Department
    {
        return $this->department;
    }
}
