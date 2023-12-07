<?php

namespace Darling\PHPFileSystemPaths\tests\classes\paths;

use \Darling\PHPFileSystemPaths\classes\paths\PathToExistingDirectory;
use \Darling\PHPFileSystemPaths\classes\paths\PathToExistingFile;
use \Darling\PHPFileSystemPaths\tests\PHPFileSystemPathsTest;
use \Darling\PHPFileSystemPaths\tests\interfaces\paths\PathToExistingFileTestTrait;
use \Darling\PHPTextTypes\classes\strings\Name;
use \Darling\PHPTextTypes\classes\strings\Text;

class PathToExistingFileTest extends PHPFileSystemPathsTest
{

    /**
     * The PathToExistingFileTestTrait defines common tests for
     * implementations of the
     * Darling\PHPFileSystemPaths\interfaces\paths\PathToExistingFile
     * interface.
     *
     * @see PathToExistingFileTestTrait
     *
     */
    use PathToExistingFileTestTrait;

    public function setUp(): void
    {
        $pathToExistingDirectory = new PathToExistingDirectory(
            $this->safeTextCollectionThatMapsToThePHPFileSystemPathsLibrarysTestsDirectory()
        );
        $nameOfFileThatExistsInThePHPFileSystemPathsTestsDirectory =
            $this->nameOfFileThatExistsInPHPFileSystemPathsTestsDirectory();
        $nameOfFileThatDoesNotExistInThePHPFileSystemPathsTestsDirectory =
            new Name(new Text($this->randomChars()));
        $testFileName = (
            rand(0, 1)
            ? $nameOfFileThatExistsInThePHPFileSystemPathsTestsDirectory
            : $nameOfFileThatDoesNotExistInThePHPFileSystemPathsTestsDirectory
        );
        $this->setExpectedPathAndFileName(
            $pathToExistingDirectory,
            $testFileName,
        );
        $this->setPathToExistingFileTestInstance(
            new PathToExistingFile($pathToExistingDirectory, $testFileName)
        );
    }
}

