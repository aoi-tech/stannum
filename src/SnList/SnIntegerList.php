<?php

declare(strict_types=1);

namespace Tumugin\Stannum\SnList;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Tumugin\Stannum\SnInteger;
use Tumugin\Stannum\SnList;

class SnIntegerList extends SnNumericList
{
    /**
     * Creates SnIntegerList instance by native array.
     *
     * @throws AssertionFailedException
     */
    public static function fromArray(array $value): self
    {
        return new static(parent::fromArrayStrictWithType($value, SnInteger::class)->toArray());
    }

    /**
     * Creates SnIntegerList instance by native array which includes single type.
     *
     * @param SnInteger[] $value Base array
     * @return static
     * @throws AssertionFailedException
     */
    public static function fromArrayStrict(array $value): self
    {
        return new static(parent::fromArrayStrictWithType($value, SnInteger::class)->toArray());
    }

    /**
     * Creates SnIntegerList instance by native array which includes only one specified type.
     *
     * @param SnInteger[] $value Base array
     * @param string $type Type of value
     * @return static
     * @throws AssertionFailedException
     */
    public static function fromArrayStrictWithType(array $value, string $type): self
    {
        Assertion::same($type, SnInteger::class, '$type must be SnInteger');
        return new static(parent::fromArrayStrictWithType($value, $type)->toArray());
    }

    /**
     * Creates SnFloatList instance by native integer array.
     *
     * @param int[] $value Base array
     * @return SnIntegerList
     * @throws AssertionFailedException
     */
    public static function fromIntArray(array $value): self
    {
        return new static(
            SnList::fromArrayStrictWithType($value, 'integer')
                ->map(fn(int $v) => SnInteger::byInt($v))
                ->toArray()
        );
    }

    /**
     * Convert to native int array.
     *
     * @return int[]
     */
    public function toIntArray(): array
    {
        return $this
            ->map(fn(SnInteger $v) => $v->toInt())
            ->toArray();
    }

    public function total(): SnInteger
    {
        return parent::total();
    }

    public function max(): SnInteger
    {
        return parent::max();
    }

    public function min(): SnInteger
    {
        return parent::min();
    }
}
