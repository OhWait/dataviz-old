<?php

declare(strict_types=1);

namespace App\Shared\Domain\UseCase\Validator;

use App\Shared\Domain\Enum\ViolationTypeEnum;

abstract class AbstractValidator implements ValidatorInterface
{
    /**
     * @var Violation[]
     */
    protected array $violations = [];

    /**
     * @return Violation[]
     */
    public function violations(): array
    {
        return $this->violations;
    }

    public function isInvalid(): bool
    {
        $errorsViolations = array_filter(
            $this->violations,
            fn (Violation $violation) => $violation->isError(),
        );

        return \count($errorsViolations) > 0;
    }

    protected function addViolation(
        string $message,
        string $propertyPath,
        ViolationTypeEnum $type,
        string $invalidValue = '',
    ): self {
        $this->violations[] = new Violation(
            $message,
            $propertyPath,
            $type,
            $invalidValue,
        );

        return $this;
    }

    /**
     * @param string[] $authorizedValues
     */
    protected function addViolationWithAllowedValues(
        array $authorizedValues,
        string $fullPropertyPath,
        ViolationTypeEnum $type,
        string $invalidValue,
    ): self {
        return $this->addViolation(
            message: sprintf(
                'The column you selected is not a valid choice. Allowed columns are [ %s ]',
                join(', ', $authorizedValues),
            ),
            propertyPath: $fullPropertyPath,
            type: $type,
            invalidValue: $invalidValue,
        );
    }
}
