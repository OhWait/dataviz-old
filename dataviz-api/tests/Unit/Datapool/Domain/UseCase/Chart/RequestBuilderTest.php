<?php

declare(strict_types=1);

namespace App\Tests\Unit\Datapool\Domain\UseCase\Chart;

use App\Domain\Datapool\Enum\Chart\OperationTypeEnum;
use App\Domain\Datapool\Model\Chart\Request;
use App\Domain\Datapool\UseCase\Chart\RequestBuilder;
use App\Domain\Dataviz\Enum\MetaColumn\DataTypeEnum;
use App\Domain\Dataviz\Model\DataEntry;
use App\Domain\Dataviz\Model\MetaColumn;
use App\Tests\Data\Datapool\Builder\Cqrs\MakeChartCommandBuilder;
use App\Tests\Data\Dataviz\Builder\Model\DatasetBuilder;
use PHPUnit\Framework\TestCase;
use Zenstruck\Foundry\Test\Factories;

class RequestBuilderTest extends TestCase
{
    use Factories;

    public const GOOD_SLUG = 'GOOD_SLUG';
    public const GOOD_SLUG2 = 'GOOD_SLUG2';
    public const WRONG_SLUG = 'WRONG_SLUG';
    public const WRONG_SLUG2 = 'WRONG_SLUG2';

    public const COLUMN = [
        self::GOOD_SLUG => 'columnName',
        self::GOOD_SLUG2 => 'columnName2',
        self::WRONG_SLUG => 'wrong_columnName',
        self::WRONG_SLUG2 => 'wrong_columnName2',
    ];

    public const DATASET = [
        self::GOOD_SLUG => 'datasetSlug',
        self::GOOD_SLUG2 => 'datasetSlug2',
        self::WRONG_SLUG => 'wrong_datasetSlug',
        self::WRONG_SLUG2 => 'wrong_datasetSlug2',
    ];

    private readonly DatasetBuilder $datasetBuilder;
    private readonly MakeChartCommandBuilder $chartCommandBuilder;
    private ?OperationTypeEnum $operationType = null;
    private ?OperationTypeEnum $dateOperationType = null;
    private Request $request;

    public function setUp(): void
    {
        $this->datasetBuilder = new DatasetBuilder();
        $this->chartCommandBuilder = new MakeChartCommandBuilder();
    }

    public function testWithWrongColumnAndOneEntryRequestAndOneEntryIndicatorShouldHaveDefaultEntryAndEmptyMetaIntoRequest(): void
    {
        $this
            ->withWrongColumnAndNoDataSlugRequest()
            ->withOneDataEntryIntoDataset()
            ->process()
            ->shouldHaveDefaultDataEntry()
            ->shouldHaveEmptyMetaColumnIntoRequest();
    }

    public function testWithGoodColumnAndOneEntryRequestAndOneEntryIndicatorShouldHaveDefaultEntryAndMetaIntoRequest(): void
    {
        $this
            ->withGoodColumnAndNoDataSlugRequest()
            ->withOneDataEntryIntoDataset()
            ->process()
            ->shouldHaveDefaultDataEntry()
            ->shouldHaveMetaColumnIntoRequest();
    }

    public function testWithWrongColumnAndNoDataSlugRequestAndMultipleEntryIndicatorShouldNotSetDefaultDataEntry(): void
    {
        $this
            ->withWrongColumnAndWrongDataSlugRequest()
            ->withMultipleDataEntryIntoDataset()
            ->process()
            ->shouldHaveNoDataEntry()
            ->shouldHaveEmptyMetaColumnIntoRequest();
    }

    public function testWithOperationTypeAggregateAndMetaAggregableShouldNotprocessRequest(): void
    {
        $this
            ->withOperationTypeAggregateAndAggregableMeta()
            ->withOneDataEntryAndMetaAggregableIntoDataset()
            ->process()
            ->shoudNotprocessOperationTypeRequest();
    }

    public function testWithOperationTypeAggregateAndMetaNotAggregableShouldprocessRequest(): void
    {
        $this
            ->withOperationTypeAggregateAndAggregableMeta()
            ->withOneDataEntryAndMetaNotAggregableIntoDataset()
            ->process()
            ->shoudprocessOperationTypeRequest();
    }

    public function testWithDateOperationTypeAggregateAndMetaAggregableShouldNotprocessRequest(): void
    {
        $this
            ->withOperationTypeAggregateAndAggregableMeta()
            ->withOneDataEntryAndMetaAggregableIntoDataset()
            ->process()
            ->shoudNotprocessDateOperationTypeRequest();
    }

    public function testWithDateOperationTypeAggregateAndMetaNotDateAggregableShouldprocessRequest(): void
    {
        $this
            ->withOperationTypeAggregateAndAggregableMeta()
            ->withOneDataEntryAndMetaNotAggregableIntoDataset()
            ->process()
            ->shoudDeleteDateOperationTypeRequest();
    }

    public function testWithAxisWrongColumnAndGoodDataSlugAndMultipleEntryShouldHaveDefaultDataEntryAndEmptyMeta(): void
    {
        $this
            ->withWrongColumnAndGoodDataSlugRequest()
            ->withMultipleDataEntryIntoDataset()
            ->process()
            ->shouldHaveDefaultDataEntry()
            ->shouldHaveEmptyMetaColumnIntoRequest();
    }

    public function testWithAxisGoodColumnAndGoodDataSlugAndMultipleEntryShouldHaveDataEntryAndMeta(): void
    {
        $this
            ->withGoodColumnAndGoodDataSlugRequest()
            ->withMultipleDataEntryIntoDataset()
            ->process()
            ->shouldHaveDefaultDataEntry()
            ->shouldHaveMetaColumnIntoRequest();
    }

    public function testWithAxisGoodColumnAndWrongDataSlugAndMultipleEntryShouldHaveNoEntryAndEmptyMeta(): void
    {
        $this
            ->withGoodColumnAndWrongDataSlugRequest()
            ->withMultipleDataEntryIntoDataset()
            ->process()
            ->shouldHaveNoDataEntry()
            ->shouldHaveEmptyMetaColumnIntoRequest();
    }

    public function testWithGoodRequestAndGoodFiltersAndOneEntryShouldHaveFilters(): void
    {
        $this
            ->withGoodColumnAndGoodDataSlugRequest()
            ->withGoodFiltersIntoRequest()
            ->withOneDataEntryIntoDataset()
            ->process()
            ->shouldHaveDefaultDataEntry()
            ->shouldHaveMetaColumnIntoRequest()
            ->shouldHaveDataEntryIntoRequestFilters()
            ->shouldHaveMetaColumnIntoRequestFilters();
    }

    public function testWithGoodRequestAndGoodFiltersAndMultipleEntryShouldHaveFilters(): void
    {
        $this
            ->withGoodColumnAndGoodDataSlugRequest()
            ->withGoodFiltersIntoRequest()
            ->withMultipleDataEntryIntoDataset()
            ->process()
            ->shouldHaveDefaultDataEntry()
            ->shouldHaveMetaColumnIntoRequest()
            ->shouldHaveDataEntryIntoRequestFilters()
            ->shouldHaveMetaColumnIntoRequestFilters();
    }

    public function testWithGoodRequestAndWrongFiltersAndMultipleEntryShouldHaveRemovedFilters(): void
    {
        $this
            ->withGoodColumnAndGoodDataSlugRequest()
            ->withWrongFiltersIntoRequest()
            ->withMultipleDataEntryIntoDataset()
            ->process()
            ->shouldHaveDefaultDataEntry()
            ->shouldHaveMetaColumnIntoRequest()
            ->shouldHaveRemovedFiltersIntoRequest();
    }

    private function withWrongColumnAndNoDataSlugRequest(): self
    {
        $this->chartCommandBuilder
            ->withAxisOperation(self::COLUMN[self::WRONG_SLUG])
            ->withAxisDistribution(self::COLUMN[self::WRONG_SLUG2])
            ->withValues(self::COLUMN[self::WRONG_SLUG2])
            ->withSerie(self::COLUMN[self::WRONG_SLUG]);

        return $this;
    }

    private function withGoodColumnAndNoDataSlugRequest(): self
    {
        $this->chartCommandBuilder
            ->withAxisOperation(self::COLUMN[self::GOOD_SLUG])
            ->withAxisDistribution(self::COLUMN[self::GOOD_SLUG])
            ->withValues(self::COLUMN[self::GOOD_SLUG])
            ->withAxisDistribution(self::COLUMN[self::GOOD_SLUG]);

        return $this;
    }

    // ARRANGE
    private function withWrongColumnAndWrongDataSlugRequest(): self
    {
        $this->chartCommandBuilder
            ->withAxisOperation(
                self::COLUMN[self::WRONG_SLUG],
                self::DATASET[self::WRONG_SLUG],
            )
            ->withAxisDistribution(
                self::COLUMN[self::WRONG_SLUG],
                self::DATASET[self::WRONG_SLUG],
            )
            ->withValues(
                self::COLUMN[self::WRONG_SLUG],
                self::DATASET[self::WRONG_SLUG],
            )
            ->withSerie(
                self::COLUMN[self::WRONG_SLUG2],
                self::DATASET[self::WRONG_SLUG2],
            );

        return $this;
    }

    private function withWrongColumnAndGoodDataSlugRequest(): self
    {
        $this->chartCommandBuilder
            ->withValues(
                self::COLUMN[self::WRONG_SLUG],
                self::DATASET[self::GOOD_SLUG],
            )
            ->withAxisOperation(
                self::COLUMN[self::WRONG_SLUG],
                self::DATASET[self::GOOD_SLUG],
            )
            ->withAxisDistribution(
                self::COLUMN[self::WRONG_SLUG],
                self::DATASET[self::GOOD_SLUG],
            )
            ->withSerie(
                self::COLUMN[self::WRONG_SLUG],
                self::DATASET[self::GOOD_SLUG],
            );

        return $this;
    }

    private function withGoodColumnAndWrongDataSlugRequest(): self
    {
        $this->chartCommandBuilder
            ->withValues(
                self::COLUMN[self::GOOD_SLUG],
                self::DATASET[self::WRONG_SLUG],
            )
            ->withAxisOperation(
                self::COLUMN[self::GOOD_SLUG],
                self::DATASET[self::WRONG_SLUG],
            )
            ->withAxisDistribution(
                self::COLUMN[self::GOOD_SLUG],
                self::DATASET[self::WRONG_SLUG],
            )
            ->withSerie(
                self::COLUMN[self::GOOD_SLUG],
                self::DATASET[self::WRONG_SLUG],
            );

        return $this;
    }

    private function withGoodColumnAndGoodDataSlugRequest(): self
    {
        $this->chartCommandBuilder
            ->withValues(
                self::COLUMN[self::GOOD_SLUG],
                self::DATASET[self::GOOD_SLUG],
            )
            ->withAxisOperation(
                self::COLUMN[self::GOOD_SLUG],
                self::DATASET[self::GOOD_SLUG],
            )
            ->withAxisDistribution(
                self::COLUMN[self::GOOD_SLUG],
                self::DATASET[self::GOOD_SLUG],
            )
            ->withSerie(
                self::COLUMN[self::GOOD_SLUG],
                self::DATASET[self::GOOD_SLUG],
            );

        return $this;
    }

    private function withOperationTypeAggregateAndAggregableMeta(): self
    {
        $this->operationType = OperationTypeEnum::SUM;
        $this->dateOperationType = OperationTypeEnum::DAILY;

        $this->chartCommandBuilder
            ->withAxisOperation(
                self::COLUMN[self::GOOD_SLUG],
                self::DATASET[self::GOOD_SLUG],
                OperationTypeEnum::SUM,
            )
            ->withAxisDistribution(
                self::COLUMN[self::GOOD_SLUG2],
                self::DATASET[self::GOOD_SLUG2],
                OperationTypeEnum::DAILY,
            );

        return $this;
    }

    private function withGoodFiltersIntoRequest(): self
    {
        $this->chartCommandBuilder->addFilter(
            self::COLUMN[self::GOOD_SLUG],
            self::DATASET[self::GOOD_SLUG],
        );

        return $this;
    }

    private function withWrongFiltersIntoRequest(): self
    {
        $this->chartCommandBuilder->addFilter(
            self::COLUMN[self::WRONG_SLUG],
            self::DATASET[self::WRONG_SLUG],
        );

        return $this;
    }

    private function withOneDataEntryIntoDataset(): self
    {
        $this->datasetBuilder
            ->addMetaColumn(self::COLUMN[self::GOOD_SLUG], DataTypeEnum::NUMERIC)
            ->addMetaColumn(self::COLUMN[self::GOOD_SLUG2], DataTypeEnum::NUMERIC)
            ->addDataEntry();

        return $this;
    }

    private function withOneDataEntryAndMetaAggregableIntoDataset(): self
    {
        $this->datasetBuilder
            ->addMetaColumn(self::COLUMN[self::GOOD_SLUG], DataTypeEnum::INTEGER)
            ->addMetaColumn(self::COLUMN[self::GOOD_SLUG2], DataTypeEnum::TIMESTAMP_WTZ)
            ->addDataEntry();

        return $this;
    }

    private function withOneDataEntryAndMetaNotAggregableIntoDataset(): self
    {
        $this->datasetBuilder
            ->addMetaColumn(self::COLUMN[self::GOOD_SLUG], DataTypeEnum::CHARACTER_VARYING)
            ->addMetaColumn(self::COLUMN[self::GOOD_SLUG2], DataTypeEnum::CHARACTER_VARYING)
            ->addDataEntry();

        return $this;
    }

    private function withMultipleDataEntryIntoDataset(): self
    {
        $this->datasetBuilder
            ->addMetaColumn(self::COLUMN[self::GOOD_SLUG])
            ->addDataEntry(self::DATASET[self::GOOD_SLUG])
            ->addMetaColumn(self::COLUMN[self::GOOD_SLUG2])
            ->addDataEntry(self::DATASET[self::GOOD_SLUG2]);

        return $this;
    }

    // ACT
    private function process(): self
    {
        $request = new RequestBuilder($this->datasetBuilder->build());

        $this->request = $request->build($this->chartCommandBuilder->build());

        return $this;
    }

    // ASSERT
    private function shouldHaveDefaultDataEntry(): self
    {
        $this->assertNotEmpty($this->request->protectedParams());

        foreach ($this->request->protectedParams() as $name => $param) {
            $this->assertInstanceOf(DataEntry::class, $param->dataEntry(), "Param name: {$name}");
        }

        return $this;
    }

    private function shouldHaveNoDataEntry(): self
    {
        $this->assertNotEmpty($this->request->protectedParams());

        foreach ($this->request->protectedParams() as $name => $param) {
            $this->assertNull($param->dataEntry(), "Param name: {$name}");
        }

        return $this;
    }

    private function shouldHaveMetaColumnIntoRequest(): self
    {
        $this->assertNotEmpty($this->request->protectedParams());

        foreach ($this->request->protectedParams() as $name => $param) {
            $this->assertInstanceOf(MetaColumn::class, $param->meta(), "Param name: {$name}");
        }

        return $this;
    }

    private function shouldHaveEmptyMetaColumnIntoRequest(): self
    {
        $this->assertNotEmpty($this->request->protectedParams());

        foreach ($this->request->protectedParams() as $name => $param) {
            $this->assertNull($param->meta(), "Param name: {$name}");
        }

        return $this;
    }

    private function shouldHaveDataEntryIntoRequestFilters(): self
    {
        $this->assertNotEmpty($this->request->filters());

        foreach ($this->request->protectedParams() as $name => $param) {
            $this->assertInstanceOf(DataEntry::class, $param->dataEntry(), "Param name: {$name}");
        }

        return $this;
    }

    private function shouldHaveMetaColumnIntoRequestFilters(): self
    {
        $this->assertNotEmpty($this->request->filters());

        foreach ($this->request->protectedParams() as $name => $param) {
            $this->assertInstanceOf(MetaColumn::class, $param->meta(), "Param name: {$name}");
        }

        return $this;
    }

    private function shouldHaveRemovedFiltersIntoRequest(): self
    {
        $this->assertEquals(0, $this->request->filters()->count());

        return $this;
    }

    private function shoudNotprocessOperationTypeRequest(): self
    {
        $this->assertNotNull($this->request->axisOperation()?->operationType());
        $this->assertSame($this->operationType?->value, $this->request->axisOperation()?->operationType()->value);

        return $this;
    }

    private function shoudNotprocessDateOperationTypeRequest(): self
    {
        $this->assertNotNull($this->request->axisDistribution()?->dateOperation());
        $this->assertSame($this->dateOperationType?->value, $this->request->axisDistribution()?->dateOperation()->value);

        return $this;
    }

    private function shoudprocessOperationTypeRequest(): self
    {
        $this->assertNotNull($this->request->axisOperation()->operationType());
        $this->assertTrue($this->operationType->value !== $this->request->axisOperation()->operationType()->value);

        return $this;
    }

    private function shoudDeleteDateOperationTypeRequest(): self
    {
        $this->assertNotNull($this->request->axisDistribution());
        $this->assertNull($this->request->axisDistribution()->dateOperation());

        return $this;
    }
}
