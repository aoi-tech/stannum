<?php
declare(strict_types=1);

namespace Tumugin\Stannum;

use Assert\Assertion;
use Assert\AssertionFailedException;

class SnPositiveInteger extends SnInteger
{
    /**
     * @throws AssertionFailedException
     */
    public static function byString(string $value): SnPositiveInteger
    {
        Assertion::true(filter_var($value, FILTER_VALIDATE_INT), 'Input value is not valid integer.');
        $parsed_value = intval($value);
        Assertion::greaterThan($parsed_value, 0, 'Value must be greater than 0.');

        return new SnPositiveInteger($parsed_value);
    }

    /**
     * @throws AssertionFailedException
     */
    public static function byInt(int $value): SnPositiveInteger
    {
        Assertion::greaterThan($value, 0, 'Value must be greater than 0.');

        return new SnPositiveInteger($value);
    }
}