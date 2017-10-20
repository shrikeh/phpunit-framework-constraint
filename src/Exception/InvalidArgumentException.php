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

final class InvalidArgumentException extends \InvalidArgumentException implements ConstraintException
{
    /**
     * @param int    $argument
     * @param string $type
     * @param mixed  $value
     *
     * @return self
     */
    public static function type(int $argument, string $type, $value = null): self
    {
        $stack = \debug_backtrace();

        return new static(\sprintf(
            'Argument #%d (%s) of %s::%s() must be a %s',
            $argument,
            $value !== null ? \gettype($value) . '#' . $value : 'No Value',
            $stack[1]['class'],
            $stack[1]['function'],
            $type
        ));
    }
}
