<?php

declare(strict_types=1);

namespace App\Domain\Dataviz\Model;

use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnCharacterMaximumLength;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnColumnName;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnDataType;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnId;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnLabel;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnNullable;
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
        private ?DataEntry $dataEntry = null,
    ) {
        $this->metaRows = new ArrayCollection();
    }

    /**
     * @codeCoverageIgnore
     */
    public function update(
        ?MetaColumnColumnName $columnName = null,
        ?MetaColumnNullable $nullable = null,
        ?MetaColumnDataType $dataType = null,
        ?MetaColumnCharacterMaximumLength $characterMaximumLength = null,
        ?MetaColumnLabel $label = null,
        ?DataEntry $dataEntry = null,
        ?array $metaRows = null,
    ): void {
        $this->columnName = $columnName ?? $this->columnName;
        $this->nullable = $nullable ?? $this->nullable;
        $this->dataType = $dataType ?? $this->dataType;
        $this->characterMaximumLength = $characterMaximumLength ?? $this->characterMaximumLength;
        $this->label = $label ?? $this->label;
        $this->dataEntry = $dataEntry ?? $this->dataEntry;
        $this->metaRows = null !== $metaRows ? new ArrayCollection($metaRows) : $this->metaRows;
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
