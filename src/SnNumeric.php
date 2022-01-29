<?php

declare(strict_types=1);

namespace Tumugin\Stannum;

/**
 * Base class of SnInteger and SnFloat.
 */
abstract class SnNumeric
{
    /** @var int|float $value Internal raw value. */
    protected $value;

    /**
     * internal: Creates instance by raw value.
     *
     * @param int|float $_value
     */
    protected function __construct($_value)
    {
        $this->value = $_value;
    }

    /**
     * internal: Converts to raw string value.
     */
    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * Converts to raw string value.
     */
    public function toString(): string
    {
        return "{$this->value}";
    }

    /**
     * Converts to raw integer value.
     */
    public function toInt(): int
    {
        return (int)$this->value;
    }

    /**
     * Converts to raw float value
     */
    public function toFloat(): float
    {
        return (float)$this->value;
    }

    /**
     * Returns the passed SnNumeric value is same as is.
     *
     * @param SnNumeric $value The SnNumeric it will be compared.
     */
    public function isEqual(SnNumeric $value): bool
    {
        return $this->value === $value->value;
    }

    /**
     * Returns the passed SnNumeric value is greater or equal than self.
     *
     * @param SnNumeric $value The SnNumeric it will be compared.
     */
    public function isGreaterOrEqualThan(SnNumeric $value): bool
    {
        return $this->value >= $value->value;
    }

    /**
     * Returns the passed SnNumeric value is greater than self.
     *
     * @param SnNumeric $value The SnNumeric it will be compared.
     */
    public function isGreaterThan(SnNumeric $value): bool
    {
        return $this->value > $value->value;
    }

    /**
     * Returns the passed SnNumeric value is less or equal than self.
     *
     * @param SnNumeric $value The SnNumeric it will be compared.
     */
    public function isLessOrEqualThan(SnNumeric $value): bool
    {
        return $this->value <= $value->value;
    }

    /**
     * Returns the passed SnNumeric value is less than self.
     *
     * @param SnNumeric $value The SnNumeric it will be compared.
     */
    public function isLessThan(SnNumeric $value): bool
    {
        return $this->value < $value->value;
    }

    /**
     * Returns the value is even.
     */
    public function isEven(): bool
    {
        return $this->value % 2 === 0;
    }

    /**
     * Returns the value is odd.
     */
    public function isOdd(): bool
    {
        return !$this->isEven();
    }
}
