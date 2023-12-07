<?php

namespace Darling\PHPFileSystemPaths\tests\classes\paths;

use \Darling\PHPFileSystemPaths\classes\paths\PathToExistingDirectory;
use \Darling\PHPFileSystemPaths\tests\PHPFileSystemPathsTest;
use \Darling\PHPFileSystemPaths\tests\interfaces\paths\PathToExistingDirectoryTestTrait;

class PathToExistingDirectoryTest extends PHPFileSystemPathsTest
{

    /**
     * The PathToExistingDirectoryTestTrait defines common tests for
     * implementations of the
     * Darling\PHPFileSystemPaths\interfaces\paths\PathToExistingDirectory
     * interface.
     *
     * @see PathToExistingDirectoryTestTrait
     *
     */
    use PathToExistingDirectoryTestTrait;

    public function setUp(): void
    {
        $safeTextCollectionForPathThatDoesNotExist =
            $this->safeTextCollectionThatMapsToADirectoryThatDoesNotExist();
        $safeTextColletionForPathThatDoesExist =
            $this->safeTextCollectionThatMapsToThePHPFileSystemPathsLibrarysTestsDirectory();
        $testSafeTextCollection = (
            rand(0, 1)
            ? $safeTextCollectionForPathThatDoesNotExist
            : $safeTextColletionForPathThatDoesExist
        );
        $this->setExpectedSafeTextCollection($testSafeTextCollection);
        $this->setPathToExistingDirectoryTestInstance(
            new PathToExistingDirectory($testSafeTextCollection)
        );
    }

}

