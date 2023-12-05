<?php

namespace Darling\PHPFileSystemPaths\tests;

use PHPUnit\Framework\TestCase;
use Darling\PHPUnitTestUtilities\traits\PHPUnitConfigurationTests;
use Darling\PHPUnitTestUtilities\traits\PHPUnitTestMessages;
use Darling\PHPUnitTestUtilities\traits\PHPUnitRandomValues;

/**
 * Defines common methods that may be useful to all
 * PHPFileSystemPaths test classes.
 *
 * All PHPFileSystemPaths test classes must extend from
 * this class.
 *
 * This class also serves as an example of how the traits
 * provided by this library can be used in a phpunit test
 * class.
 *
 */
class PHPFileSystemPathsTest extends TestCase
{
    use PHPUnitConfigurationTests;
    use PHPUnitTestMessages;
    use PHPUnitRandomValues;

    /**
     * Return a random integer to use a limit.
     *
     * Integer will be `0`, `1`, or a integer between `0` and `50000`.
     *
     * @return int
     *
     */
    protected function randomLimit(): int
    {
        $limits = [1, rand(0, 50000), 0];
        return $limits[array_rand($limits)];
    }
}
