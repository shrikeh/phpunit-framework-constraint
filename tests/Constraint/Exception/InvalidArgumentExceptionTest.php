<?php
/*
 * This file is part of sebastian/phpunit-framework-constraint.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Constraint\Exception;

use PHPUnit\Framework\TestCase;

final class InvalidArgumentExceptionTest extends TestCase
{
    public function testIsInvalidArgumentException()
    {
        $exception = new InvalidArgumentException();

        $this->assertInstanceOf(\InvalidArgumentException::class, $exception);
    }

    public function testIsConstraintException()
    {
        $exception = new InvalidArgumentException();

        $this->assertInstanceOf(ConstraintException::class, $exception);
    }

    public function testTypeCreatesExceptionWithoutValue()
    {
        $argument = 1;
        $type     = 'int';

        $exception = InvalidArgumentException::type(
            $argument,
            $type
        );

        $this->assertInstanceOf(InvalidArgumentException::class, $exception);

        $message = \sprintf(
            'Argument #%d (No Value) of %s() must be a %s',
            $argument,
            __METHOD__,
            $type
        );

        $this->assertSame($message, $exception->getMessage());
        $this->assertSame(0, $exception->getCode());
    }

    /**
     * @dataProvider providerValue
     *
     * @param mixed $value
     */
    public function testTypeCreatesExceptionWithValue($value)
    {
        $argument = 1;
        $type     = 'int';

        $exception = InvalidArgumentException::type(
            $argument,
            $type,
            $value
        );

        $this->assertInstanceOf(InvalidArgumentException::class, $exception);

        $message = \sprintf(
            'Argument #%d (%s) of %s() must be a %s',
            $argument,
            $value !== null ? \gettype($value) . '#' . $value : 'No Value',
            __METHOD__,
            $type
        );

        $this->assertSame($message, $exception->getMessage());
        $this->assertSame(0, $exception->getCode());
    }

    public function providerValue() : \Generator
    {
        $values = [
            'bool-false' => false,
            'bool-true'  => true,
            'float'      => 3.14,
            'int'        => 9000,
            'null'       => null,
            'string'     => 'Foo',
        ];

        foreach ($values as $key => $value) {
            yield $key => [
                $value,
            ];
        }
    }
}
