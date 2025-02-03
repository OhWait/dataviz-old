<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bridge;

use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class PropertyAccessor
{
    public function __construct(
        private PropertyAccessorInterface $accessor,
    ) {
    }

    public function toArray(object|array $subject, string $propertyPath): array
    {
        $value = $this->value($subject, $propertyPath);

        if (\is_array($value)) {
            return $value;
        }

        return [];
    }

    public function toFloatOrNull(object|array $subject, string $propertyPath): ?float
    {
        $value = $this->value($subject, $propertyPath);

        if (\is_numeric($value)) {
            return (float) $value;
        }

        return null;
    }

    public function toFloat(object|array $subject, string $propertyPath, float $default = 0): float
    {
        return $this->toFloatOrNull($subject, $propertyPath) ?: $default;
    }

    public function toStringOrNull(object|array $subject, string $propertyPath): ?string
    {
        $value = $this->value($subject, $propertyPath);

        if (\is_scalar($value)) {
            return (string) $value;
        }

        return null;
    }

    public function toString(object|array $subject, string $propertyPath, string $default): string
    {
        return $this->toStringOrNull($subject, $propertyPath) ?: $default;
    }

    public function value(object|array $subject, string $propertyPath): mixed
    {
        if ($this->accessor->isReadable($subject, $propertyPath)) {
            return $this->accessor->getValue($subject, $propertyPath);
        }

        return null;
    }
}
