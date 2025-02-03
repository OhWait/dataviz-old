<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

use App\Shared\Domain\UseCase\Validator\Violation;

class ViolationException extends \InvalidArgumentException
{
    /**
     * @var Violation[]
     */
    private array $violations;

    /**
     * @param Violation[] $violations
     */
    public function __construct(array $violations)
    {
        $this->violations = $violations;
    }

    public function violations(): array
    {
        return $this->violations;
    }
}
