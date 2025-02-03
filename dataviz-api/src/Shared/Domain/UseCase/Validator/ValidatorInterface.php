<?php

declare(strict_types=1);

namespace App\Shared\Domain\UseCase\Validator;

interface ValidatorInterface
{
    /**
     * @return Violation[]
     */
    public function violations(): array;

    public function isInvalid(): bool;
}
