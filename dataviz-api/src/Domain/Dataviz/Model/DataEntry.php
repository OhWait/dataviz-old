<?php

declare(strict_types=1);

namespace App\Domain\Dataviz\Model;

use App\Domain\Dataviz\ValueObject\DataEntry\DataEntryCreatedAt;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntrySchemaName;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntrySlug;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntryTableName;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntryTitle;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntryUpdatedAt;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PHPUnit\Framework\Attributes\CodeCoverageIgnore;

#[ORM\Entity]
#[ORM\Table(name: 'data_entry')]
#[ORM\UniqueConstraint(
    name: 'schema_table_unique_idx',
    columns: ['schema_name', 'table_name'],
)]
class DataEntry
{
    #[ORM\Embedded(columnPrefix: false)]
    private DataEntryCreatedAt $createdAt;

    #[ORM\Embedded(columnPrefix: false)]
    private DataEntryUpdatedAt $updatedAt;

    /** @var Collection<int, MetaColumn> */
    #[ORM\OneToMany(mappedBy: 'dataEntry', targetEntity: MetaColumn::class, orphanRemoval: true)]
    private Collection $metaColumns;

    /**
     * @param MetaColumn[] $metaColumns
     */
    public function __construct(
        #[ORM\Embedded(columnPrefix: false)]
        private DataEntrySlug $slug,

        #[ORM\Embedded(columnPrefix: false)]
        private DataEntryTitle $title,

        #[ORM\Embedded(columnPrefix: false)]
        private DataEntrySchemaName $schemaName,

        #[ORM\Embedded(columnPrefix: false)]
        private DataEntryTableName $tableName,

        #[ORM\ManyToOne(inversedBy: 'dataEntries')]
        #[ORM\JoinColumn(nullable: false, referencedColumnName: 'slug')]
        private ?Dataset $dataset = null,

        array $metaColumns = [],
    ) {
        $this->createdAt = new DataEntryCreatedAt();
        $this->updatedAt = new DataEntryUpdatedAt();
        $this->metaColumns = new ArrayCollection($metaColumns);
    }

    /**
     * @codeCoverageIgnore
     */
    public function update(
        ?DataEntryTitle $title = null,
        ?DataEntrySchemaName $schemaName = null,
        ?DataEntryTableName $tableName = null,
        ?array $metaColumns = null,
    ): void {
        $this->title = $title ?? $this->title;
        $this->schemaName = $schemaName ?? $this->schemaName;
        $this->tableName = $tableName ?? $this->tableName;
        $this->metaColumns = null !== $metaColumns ? new ArrayCollection($metaColumns) : $this->metaColumns;
        $this->updatedAt = new DataEntryUpdatedAt();
    }

    public function slug(): DataEntrySlug
    {
        return $this->slug;
    }

    public function title(): DataEntryTitle
    {
        return $this->title;
    }

    public function schemaName(): DataEntrySchemaName
    {
        return $this->schemaName;
    }

    public function tableName(): DataEntryTableName
    {
        return $this->tableName;
    }

    public function fullTableName(): string
    {
        return sprintf(
            '%s.%s',
            $this->schemaName,
            $this->tableName,
        );
    }

    public function createdAt(): DataEntryCreatedAt
    {
        return $this->createdAt;
    }

    public function updatedAt(): DataEntryUpdatedAt
    {
        return $this->updatedAt;
    }

    public function dataset(): Dataset
    {
        return $this->dataset;
    }

    /**
     * @return Collection<int, MetaColumn>
     */
    public function metaColumns(): Collection
    {
        return $this->metaColumns;
    }
}
