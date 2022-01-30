<?php

declare(strict_types=1);

namespace Tumugin\Stannum;

use ArrayIterator;
use Assert\Assertion;
use Assert\AssertionFailedException;
use Exception;

class SnList implements \Countable, \ArrayAccess, \IteratorAggregate
{
    protected array $value;

    protected function __construct(array $value)
    {
        $this->value = $value;
    }

    public static function fromArray(array $value): self
    {
        return new static(array_values($value));
    }

    /**
     * @throws AssertionFailedException
     */
    public static function fromArrayStrict(array $value): self
    {
        $types = [];
        foreach ($value as $v) {
            if (gettype($v) === 'object') {
                $types[] = get_class($v);
                continue;
            }
            $types[] = gettype($v);
        }
        Assertion::true(
            count(array_unique($types)) <= 1,
            'Base array contains multiple types.'
        );

        return new static(array_values($value));
    }

    /**
     * @throws AssertionFailedException
     */
    public static function fromArrayStrictWithType(array $value, string $type): self
    {
        foreach ($value as $v) {
            if (gettype($v) === 'object') {
                $actualType = get_class($v);
            } else {
                $actualType = gettype($v);
            }

            Assertion::same($actualType, $type, "value in array must be type of {$type}");
        }

        return new static(array_values($value));
    }

    public function toArray(): array
    {
        return $this->value;
    }

    public function length(): SnInteger
    {
        return SnInteger::byInt(count($this->value));
    }

    public function concat(self ...$value): self
    {
        $mergedArray = [...$this->value];
        foreach ($value as $snList) {
            $mergedArray = [...$mergedArray, ...$snList->value];
        }
        return new static($mergedArray);
    }

    /**
     * @param callable(mixed): bool $callback
     */
    public function filter(callable $callback): self
    {
        return new static(
            array_values(
                array_filter($this->value, $callback)
            )
        );
    }

    /**
     * @param callable(mixed): bool $callback
     */
    public function find(callable $callback)
    {
        return array_values(
            array_filter($this->value, $callback)
        )[0] ?? null;
    }

    /**
     * @throws AssertionFailedException
     */
    public function get(int $index)
    {
        Assertion::keyIsset($this->value, $index);

        return $this->value[$index];
    }

    public function getOrNull(int $index)
    {
        return $this->value[$index] ?? null;
    }

    public function isEmpty(): bool
    {
        return count($this->value) === 0;
    }

    public function contains($needle): bool
    {
        return in_array($needle, $this->value, true);
    }

    public function distinct(): self
    {
        return new static(
            array_values(
                array_unique($this->value)
            )
        );
    }

    /**
     * @throws AssertionFailedException
     */
    public function first()
    {
        Assertion::minCount($this->value, 1, 'Array must contain at least 1 item to access first element.');
        return $this->value[0];
    }

    /**
     * @throws AssertionFailedException
     */
    public function last()
    {
        Assertion::minCount($this->value, 1, 'Array must contain at least 1 item to access last element.');
        return $this->value[count($this->value) - 1];
    }

    /**
     * @param callable(mixed): mixed $callback
     */
    public function map(callable $callback): self
    {
        return new static(
            array_values(
                array_map($callback, $this->value)
            )
        );
    }

    /**
     * @param callable(mixed, mixed): mixed $callback
     */
    public function sort(callable $callback): self
    {
        $shallowCopyOfArray = $this->value;
        usort($shallowCopyOfArray, $callback);
        return new static($shallowCopyOfArray);
    }

    public function count(): int
    {
        return $this->length()->toInt();
    }

    public function offsetExists($offset): bool
    {
        return isset($this->value[$offset]);
    }

    public function offsetGet($offset)
    {
        if (!isset($this->value[$offset])) {
            throw new Exception('Index out of range.');
        }
        return $this->value[$offset];
    }

    public function offsetSet($offset, $value)
    {
        throw new Exception('Set is now allow for immutable SnList.');
    }

    public function offsetUnset($offset)
    {
        throw new Exception('Unset is now allow for immutable SnList.');
    }

    public function getIterator()
    {
        return new ArrayIterator($this->value);
    }
}
