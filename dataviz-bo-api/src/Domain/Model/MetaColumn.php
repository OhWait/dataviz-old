<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\ValueObject\MetaColumn\MetaColumnCharacterMaximumLength;
use App\Domain\ValueObject\MetaColumn\MetaColumnColumnName;
use App\Domain\ValueObject\MetaColumn\MetaColumnDataType;
use App\Domain\ValueObject\MetaColumn\MetaColumnId;
use App\Domain\ValueObject\MetaColumn\MetaColumnLabel;
use App\Domain\ValueObject\MetaColumn\MetaColumnNullable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table('meta_column')]
class MetaColumn
{
    #[ORM\Embedded(columnPrefix: false)]
    /** @phpstan-ignore-next-line */
    private MetaColumnId $id;

    /** @var Collection<int, MetaRow> */
    #[ORM\OneToMany(mappedBy: 'metaColumn', targetEntity: MetaRow::class, orphanRemoval: true)]
    private Collection $metaRows;

    public function __construct(
        #[ORM\Embedded(columnPrefix: false)]
        private MetaColumnColumnName $columnName,

        #[ORM\Embedded(columnPrefix: false)]
        private MetaColumnNullable $nullable,

        #[ORM\Embedded(columnPrefix: false)]
        private MetaColumnDataType $dataType,

        #[ORM\Embedded(columnPrefix: false)]
        public MetaColumnCharacterMaximumLength $characterMaximumLength,

        #[ORM\Embedded(columnPrefix: false)]
        private MetaColumnLabel $label,

        #[ORM\ManyToOne(targetEntity: DataEntry::class, inversedBy: 'metaColumns')]
        #[ORM\JoinColumn(nullable: false, referencedColumnName: 'slug')]
        private DataEntry $dataEntry,
    ) {
        $this->metaRows = new ArrayCollection();
    }

    public function id(): MetaColumnId
    {
        return $this->id;
    }

    public function columnName(): MetaColumnColumnName
    {
        return $this->columnName;
    }

    public function nullable(): MetaColumnNullable
    {
        return $this->nullable;
    }

    public function dataType(): MetaColumnDataType
    {
        return $this->dataType;
    }

    public function characterMaximumLength(): MetaColumnCharacterMaximumLength
    {
        return $this->characterMaximumLength;
    }

    public function label(): MetaColumnLabel
    {
        return $this->label;
    }

    public function dataEntry(): DataEntry
    {
        return $this->dataEntry;
    }

    /**
     * @return Collection<int, MetaRow>
     */
    public function metaRows(): Collection
    {
        return $this->metaRows;
    }
}
