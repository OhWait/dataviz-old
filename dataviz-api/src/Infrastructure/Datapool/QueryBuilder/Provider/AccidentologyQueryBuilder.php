<?php

declare(strict_types=1);

namespace App\Infrastructure\Datapool\QueryBuilder\Provider;

use App\Domain\Dataviz\Enum\Dataset\DataProviderEnum;
use App\Domain\Dataviz\Model\DataEntry;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntryTableName;
use App\Infrastructure\Datapool\QueryBuilder\Skeleton\AbstractProviderQueryBuilder;
use Aura\SqlQuery\Common\SelectInterface;

class AccidentologyQueryBuilder extends AbstractProviderQueryBuilder
{
    private DataEntryTableName $defaultTable;

    public function __construct()
    {
        $this->defaultTable = new DataEntryTableName('acc_caracteristique');
    }

    public function supports(DataProviderEnum $provider): bool
    {
        return DataProviderEnum::ACCIDENTOLOGY === $provider;
    }

    public function process(SelectInterface $select): void
    {
        if ($this->request->hasOneTableRequested()) {
            $select->from($this->defaultFrom());

            return;
        }

        $this->buildRelations($select);

        return;
    }

    private function buildRelations(SelectInterface $select): void
    {
        $mainTable = $this->dataset->dataEntries()->findFirst(
            fn (int $k, DataEntry $d) => $d->tableName()->equals($this->defaultTable),
        );

        $from = sprintf(
            '%s as %s',
            $mainTable->fullTableName(),
            $mainTable->tableName(),
        );

        $select->from($from);

        foreach ($this->request->dataEntries() as $dataEntry) {
            if ($dataEntry === $mainTable) {
                continue;
            }

            $select->leftJoin(
                sprintf(
                    '%s AS %s',
                    $dataEntry->fullTableName(),
                    $dataEntry->tableName(),
                ),
                sprintf(
                    '%s.%s = %s.%s',
                    $mainTable->tableName(),
                    'num_acc',
                    $dataEntry->tableName(),
                    'num_acc',
                ),
            );
        }
    }
}
