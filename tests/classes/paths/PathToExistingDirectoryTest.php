<?php

namespace Darling\PHPFileSystemPaths\tests\classes\paths;

use \Darling\PHPFileSystemPaths\classes\paths\PathToExistingDirectory;
use \Darling\PHPFileSystemPaths\tests\PHPFileSystemPathsTest;
use \Darling\PHPFileSystemPaths\tests\interfaces\paths\PathToExistingDirectoryTestTrait;
use \Darling\PHPTextTypes\classes\strings\SafeText;
use \Darling\PHPTextTypes\classes\strings\Text;
use \Darling\PHPTextTypes\classes\strings\Name;
use \Darling\PHPTextTypes\classes\collections\SafeTextCollection;

class PathToExistingDirectoryTest extends PHPFileSystemPathsTest
{

    /**
     * The PathToExistingDirectoryTestTrait defines
     * common tests for implementations of the
     * Darling\PHPFileSystemPaths\interfaces\paths\PathToExistingDirectory
     * interface.
     *
     * @see PathToExistingDirectoryTestTrait
     *
     */
    use PathToExistingDirectoryTestTrait;

    public function setUp(): void
    {
        $safeTextCollectionForPathThatDoesNotExist = new SafeTextCollection(
            new SafeText(new Name(new Text($this->randomChars()))),
            new SafeText(new Name(new Text($this->randomChars()))),
            new SafeText(new Name(new Text($this->randomChars()))),
        );
        $currentDirectoryPathParts = explode(DIRECTORY_SEPARATOR, __DIR__);
        $safeTextPartsToExistingDirectoryPath = [];
        foreach($currentDirectoryPathParts as $pathPart) {
            if(!empty($pathPart)) {
                $safeTextPartsToExistingDirectoryPath[] = new SafeText(
                    new Name(new Text($pathPart))
                );
            }
        }
        $safeTextColletionForPathThatDoesExist = new SafeTextCollection(
            ...$safeTextPartsToExistingDirectoryPath
        );
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

