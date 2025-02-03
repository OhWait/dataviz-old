<?php

declare(strict_types=1);

namespace App\Shared\Presentation;

use ApiPlatform\Validator\Exception\ValidationException as ExceptionValidationException;
use App\Shared\Domain\UseCase\Validator\Violation;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

class ValidationException
{
    /**
     * @param Violation[]
     */
    public static function toConstraintList(array $violations): ExceptionValidationException
    {
        $message = new ConstraintViolationList();

        foreach ($violations as $violation) {
            $message->add(new ConstraintViolation(
                message: $violation->message(),
                messageTemplate: null,
                parameters: [],
                root: null,
                propertyPath: $violation->propertyPath(),
                invalidValue: $violation->invalidValue(),
                code: $violation->type()->value,
            ));
        }

        return new ExceptionValidationException(
            $message,
        );
    }
}
