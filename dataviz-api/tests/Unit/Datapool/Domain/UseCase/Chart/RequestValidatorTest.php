<?php

declare(strict_types=1);

namespace App\Tests\Unit\Datapool\Domain\UseCase\Chart;

use App\Domain\Datapool\UseCase\Chart\RequestValidator;
use App\Shared\Domain\UseCase\Validator\ValidatorInterface;
use App\Tests\Data\Dataviz\Builder\Model\DataEntryBuilder;
use App\Tests\Data\Dataviz\Builder\Model\DatasetBuilder;

class RequestValidatorTest extends ColumnsValidatorTest
{
    /**
     * @var RequestValidator
     */
    protected ValidatorInterface $validator;

    public function testWithInvalidRequiredParamsAndInvalidFiltersShouldReturnInvalidValidation(): void
    {
        $this
            ->withInvalidColumnIntoRequest()
            ->withInvalidDataEntryIntoRequest()
            ->withInvalidFilters()
            ->process()
            ->shouldInvalidRequest()
            ->shouldHaveErrorViolation();
    }

    public function testWithValidRequiredParamsAndInvalidFiltersShouldReturnInvalidValidation(): void
    {
        $this
            ->withValidColumnIntoRequest()
            ->withValidDataEntryIntoRequest()
            ->withInvalidFilters()
            ->process()
            ->shouldInvalidRequest()
            ->shouldHaveErrorViolation();
    }

    public function testWithValidRequiredParamsAndValidFiltersShouldReturnValidValidation(): void
    {
        $this
            ->withValidFilters()
            ->withValidColumnIntoRequest()
            ->withValidDataEntryIntoRequest()
            ->process()
            ->shouldHaveNoViolation()
            ->shouldValidRequest();
    }

    private function withInvalidFilters(): static
    {
        $this->requestBuilder->addFilter(static::COLUMN[static::INVALID]);

        return $this;
    }

    private function withValidFilters(): static
    {
        $this->requestBuilder
            ->addFilter(
                static::COLUMN[static::VALID],
                static::DATA_ENTRY[static::VALID],
            )
            ->setDataEntryInfoFilter(
                (new DataEntryBuilder())
                    ->addMetaColumn(static::COLUMN[static::VALID])
                    ->withSlug(static::DATA_ENTRY[static::VALID])
                    ->build(),
            );

        return $this;
    }

    private function process(): static
    {
        $dataset = (new DatasetBuilder())
            ->addDataEntry(static::DATA_ENTRY[static::VALID])
            ->addMetaColumn(static::COLUMN[static::VALID])
            ->build();

        $this->validator = new RequestValidator($dataset);

        $this->validator->process(
            $this->requestBuilder->build(),
        );

        return $this;
    }
}
