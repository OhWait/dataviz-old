<?php

declare(strict_types=1);

namespace App\Tests\Unit\Datapool\Domain\UseCase\Chart;

use App\Domain\Datapool\UseCase\Chart\ColumnsValidator;
use App\Shared\Domain\UseCase\Validator\ValidatorInterface;
use App\Shared\Domain\UseCase\Validator\Violation;
use App\Tests\Data\Datapool\Builder\Model\Chart\RequestBuilder;
use App\Tests\Data\Dataviz\Builder\Model\DataEntryBuilder;
use PHPUnit\Framework\TestCase;
use Zenstruck\Foundry\Test\Factories;

class ColumnsValidatorTest extends TestCase
{
    use Factories;

    protected const VALID = 'VALID';
    protected const INVALID = 'INVALID';

    protected const DATA_ENTRY = [
        self::VALID => 'dataEntryValid',
    ];

    protected const COLUMN = [
        self::VALID => 'columnValid',
        self::INVALID => 'columnNotFound',
    ];

    private ?string $column = null;
    private ?string $dataEntry = null;

    protected RequestBuilder $requestBuilder;
    protected DataEntryBuilder $dataEntryBuilder;

    /**
     * @var ColumnsValidator
     */
    protected ValidatorInterface $validator;

    public function setUp(): void
    {
        $this->requestBuilder = new RequestBuilder();
        $this->dataEntryBuilder = new DataEntryBuilder();
    }

    public function testWithValidColumnAndValidDataEntryReturnValidRequest(): void
    {
        $this
            ->withValidColumnIntoRequest()
            ->withValidDataEntryIntoRequest()
            ->process()
            ->shouldValidRequest()
            ->shouldHaveNoViolation();
    }

    public function testWithInvalidColumnAndValidDataEntryReturnInvalidRequest(): void
    {
        $this
            ->withInvalidColumnIntoRequest()
            ->withValidDataEntryIntoRequest()
            ->process()
            ->shouldInvalidRequest()
            ->shouldHaveErrorViolation();
    }

    public function testWithValidColumnAndInvalidDataEntryReturnInvalidRequest(): void
    {
        $this
            ->withValidColumnIntoRequest()
            ->withInvalidDataEntryIntoRequest()
            ->process()
            ->shouldHaveErrorViolation()
            ->shouldInvalidRequest();
    }

    public function testWithInvalidColumnAndInvalidDataEntryReturnInvalidRequest(): void
    {
        $this
            ->withInvalidColumnIntoRequest()
            ->withInvalidDataEntryIntoRequest()
            ->process()
            ->shouldInvalidRequest()
            ->shouldHaveErrorViolation();
    }

    // ARRANGE
    protected function withValidColumnIntoRequest(): static
    {
        $this->column = self::COLUMN[self::VALID];

        return $this;
    }

    protected function withInvalidColumnIntoRequest(): static
    {
        $this->column = self::COLUMN[self::INVALID];

        return $this;
    }

    protected function withValidDataEntryIntoRequest(): static
    {
        $this->dataEntry = self::DATA_ENTRY[self::VALID];

        return $this;
    }

    protected function withInvalidDataEntryIntoRequest(): static
    {
        $this->dataEntry = null;

        return $this;
    }

    // ACT
    private function process(): self
    {
        $dataEntry = (new DataEntryBuilder())
            ->addMetaColumn(self::COLUMN[self::VALID])
            ->withSlug(self::DATA_ENTRY[self::VALID])
            ->build();

        $request = $this->requestBuilder
            ->withValues(
                $this->column,
                $this->dataEntry,
                null === $this->dataEntry ? null : $dataEntry,
            )
            ->withAxisDistribution(
                $this->column,
                $this->dataEntry,
                null === $this->dataEntry ? null : $dataEntry,
            )
            ->withAxisOperation(
                $this->column,
                $this->dataEntry,
                null === $this->dataEntry ? null : $dataEntry,
            )
            ->withSerie(
                $this->column,
                $this->dataEntry,
                null === $this->dataEntry ? null : $dataEntry,
            )
            ->build()
            ->protectedParams();

        $this->validator = new ColumnsValidator($dataEntry->dataset());

        $this->validator->process($request);

        return $this;
    }

    // ASSERT
    protected function shouldInvalidRequest(): static
    {
        $this->assertTrue($this->validator->isInvalid());

        return $this;
    }

    protected function shouldValidRequest(): static
    {
        $this->assertFalse(
            $this->validator->isInvalid(),
            $this->messageForFailViolation(),
        );

        return $this;
    }

    protected function shouldHaveErrorViolation(): static
    {
        $this->assertNotEmpty($this->validator->violations());
        $this->assertContainsOnlyInstancesOf(Violation::class, $this->validator->violations());

        return $this;
    }

    protected function shouldHaveNoViolation(): static
    {
        $this->assertEmpty(
            $this->validator->violations(),
            $this->messageForFailViolation(),
        );

        return $this;
    }

    protected function messageForFailViolation(): string
    {
        return join(
            '',
            \array_map(
                fn (Violation $violation) => '- '.$violation->propertyPath().' = '.$violation->invalidValue().' -> '.$violation->message()."\n",
                $this->validator->violations(),
            ),
        );
    }
}
