<?php

declare(strict_types=1);

namespace App\Domain\Datapool\UseCase\Chart;

use App\Domain\Datapool\Model\Chart\Request;
use App\Domain\Dataviz\Model\Dataset;
use App\Shared\Domain\UseCase\Validator\ValidatorInterface;
use App\Shared\Domain\UseCase\Validator\Violation;

/**
 * RequestValidator is a simple class for validating the request before processing it into database.
 *
 * RequestValidator is a class exists to validate and help provide people with an understanding
 * as to how their request contains mistakes.
 *
 * @author Maxime <maxime.preuilh@gmail.com>
 */
class RequestValidator implements ValidatorInterface
{
    private ColumnsValidator $columnsValidator;

    public function __construct(Dataset $dataset)
    {
        $this->columnsValidator = new ColumnsValidator($dataset);
    }

    public function process(Request $request): self
    {
        return $this
            ->validateColumnsFromRequiredParams($request)
            ->validateFilters($request);
    }

    public function isInvalid(): bool
    {
        return $this->columnsValidator->isInvalid();
    }

    /**
     * @return Violation[]
     */
    public function violations(): array
    {
        return $this->columnsValidator->violations();
    }

    private function validateColumnsFromRequiredParams(Request $request): self
    {
        $this->columnsValidator->process($request->protectedParams());

        return $this;
    }

    /**
     * This should never return violations : RequestBuilder took care of cleaning up filters
     * However this function could be use to check the values ​​passed in the filters.
     */
    private function validateFilters(Request $request): self
    {
        $desiredFiltersForValidation = [];

        foreach ($request->filters()->toArray() as $index => $filter) {
            $desiredFiltersForValidation["filters[{$index}]"] = $filter;
        }

        $this->columnsValidator->process($desiredFiltersForValidation);

        return $this;
    }
}
