<?php

declare(strict_types=1);

namespace App\Shared\Domain\UseCase\Validator;

use App\Shared\Domain\Enum\ViolationTypeEnum;

class Violation
{
    public function __construct(
        private string $message,
        private string $propertyPath,
        private ViolationTypeEnum $type,
        private string $invalidValue,
    ) {
    }

    public function message(): string
    {
        return $this->message;
    }

    public function propertyPath(): string
    {
        return $this->propertyPath;
    }

    public function type(): ViolationTypeEnum
    {
        return $this->type;
    }

    public function isError(): bool
    {
        return ViolationTypeEnum::ERROR === $this->type;
    }

    public function invalidValue(): string
    {
        return $this->invalidValue;
    }
}
