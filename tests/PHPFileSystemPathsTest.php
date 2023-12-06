<?php

namespace Darling\PHPFileSystemPaths\tests;

use \Darling\PHPUnitTestUtilities\traits\PHPUnitConfigurationTests;
use \Darling\PHPUnitTestUtilities\traits\PHPUnitRandomValues;
use \Darling\PHPUnitTestUtilities\traits\PHPUnitTestMessages;
use \PHPUnit\Framework\TestCase;
use \Darling\PHPTextTypes\classes\collections\SafeTextCollection;
use \Darling\PHPTextTypes\classes\strings\Name;
use \Darling\PHPTextTypes\classes\strings\SafeText;
use \Darling\PHPTextTypes\classes\strings\Text;

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


    /**
     * Return a SafeTextCollection that maps to a directory that
     * does not exist.
     *
     * @return SafeTextCollection
     *
     */
    public function safeTextCollectionThatMapsToADirectoryThatDoesNotExist(): SafeTextCollection
    {
        return new SafeTextCollection(
            new SafeText(new Name(new Text($this->randomChars()))),
            new SafeText(new Name(new Text($this->randomChars()))),
            new SafeText(new Name(new Text($this->randomChars()))),
        );
    }

    /**
     * Return a SafeTextCollection that maps to a directory that
     * does exist.
     *
     * @return SafeTextCollection
     *
     */
    public function safeTextCollectionThatMapsToADirectoryThatDoesExist(): SafeTextCollection
    {
        $currentDirectoryPathParts = explode(
            DIRECTORY_SEPARATOR,
            __DIR__
        );
        $safeTextPartsToExistingDirectoryPath = [];
        foreach($currentDirectoryPathParts as $pathPart) {
            if(!empty($pathPart)) {
                $safeTextPartsToExistingDirectoryPath[] =
                    new SafeText(
                        new Name(new Text($pathPart))
                    );
            }
        }
        return new SafeTextCollection(
            ...$safeTextPartsToExistingDirectoryPath
        );
    }
}
