<?php
/*
 * This file is part of sebastian/phpunit-framework-constraint.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Framework\Constraint\Exception;

use PHPUnit\Framework\SelfDescribing;
use RuntimeException;
use SebastianBergmann\Comparator\ComparisonFailure;

final class ExpectationFailedException extends RuntimeException implements ConstraintException, SelfDescribing
{
    /**
     * @var null|ComparisonFailure
     */
    private $comparisonFailure;

    /**
     * @param string $failureDescription
     * @param ComparisonFailure|null $comparisonFailure
     * @return ExpectationFailedException
     */
    public static function fail(
        string $failureDescription,
        ComparisonFailure $comparisonFailure = null
    ): ExpectationFailedException {
        return new self($failureDescription, $comparisonFailure);
    }

    /**
     * @param string $description
     * @param ComparisonFailure $comparisonFailure
     * @return ExpectationFailedException
     */
    public static function comparisonFailure(
        string $description,
        ComparisonFailure $comparisonFailure
    ): ExpectationFailedException {
        $message = \trim($description . "\n" . $comparisonFailure->getMessage());
        return new self($message, $comparisonFailure);
    }

    /**
     * @param string $message
     * @param ComparisonFailure|null $comparisonFailure
     * @param \Exception|null $previous
     */
    public function __construct(
        string $message,
        ComparisonFailure $comparisonFailure = null,
        \Exception $previous = null
    ) {
        $this->comparisonFailure = $comparisonFailure;

        parent::__construct($message, 0, $previous);
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return $this->getMessage();
    }

    /**
     * @return null|ComparisonFailure
     */
    public function getComparisonFailure()
    {
        return $this->comparisonFailure;
    }
}
