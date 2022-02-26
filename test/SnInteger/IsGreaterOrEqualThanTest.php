<?php

declare(strict_types=1);

namespace Tumugin\Stannum\Test\SnInteger;

use PHPUnit\Framework\TestCase;
use Tumugin\Stannum\SnInteger;

class IsGreaterOrEqualThanTest extends TestCase
{
    /**
     * @dataProvider providesTestInteger
     */
    public function testIsGreaterOrEqualThan(int $baseInt, int $comparedInt, bool $expected): void
    {
        $this->assertSame(
            $expected,
            SnInteger::byInt($baseInt)->isGreaterOrEqualThan(SnInteger::byInt($comparedInt))
        );
    }

    /**
     * @return array{0:int, 1:int, 2:bool}[]
     */
    public function providesTestInteger(): array
    {
        return [
            [0, 100, false],
            [99, 100, false],
            [100, 100, true],
            [101, 100, true],
            [200, 100, true],
        ];
    }
}
