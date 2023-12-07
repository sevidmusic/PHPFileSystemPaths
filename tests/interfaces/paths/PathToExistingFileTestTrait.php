<?php

namespace Darling\PHPFileSystemPaths\tests\interfaces\paths;

use \Darling\PHPFileSystemPaths\classes\paths\PathToExistingDirectory as PathToExistingDirectoryInstance;
use \Darling\PHPFileSystemPaths\interfaces\paths\PathToExistingDirectory;
use \Darling\PHPFileSystemPaths\interfaces\paths\PathToExistingFile;
use \Darling\PHPTextTypes\classes\strings\Name as NameInstance;
use \Darling\PHPTextTypes\classes\strings\Text;
use \Darling\PHPTextTypes\interfaces\collections\SafeTextCollection;
use \Darling\PHPTextTypes\interfaces\strings\Name;

/**
 * The PathToExistingFileTestTrait defines common tests for
 * implementations of the PathToExistingFile interface.
 *
 * @see PathToExistingFile
 *
 */
trait PathToExistingFileTestTrait
{

    /**
     * @var PathToExistingFile $pathToExistingFile
     *                              An instance of a
     *                              PathToExistingFile
     *                              implementation to test.
     */
    protected PathToExistingFile $pathToExistingFile;


    /**
     * @var PathToExistingDirectory $expectedPathToExistingDirectory
     *                              The PathToExistingDirectory
     *                              instance that is expected to be
     *                              returned by the PathToExistingFile.
     *                              being tested's
     *                              pathToExistingDirectory() method.
     */
    private PathToExistingDirectory $expectedPathToExistingDirectory;

    /**
     * @var Name $expectedName The Name instance that is expected to
     *                         be returned by the PathToExistingFile
     *                         being tested's name() method.
     */
    private Name $expectedName;

    /**
     * Set up an instance of a PathToExistingFile implementation to
     * test.
     *
     * This method must set the PathToExistingFile
     * implementation instance to be tested via the
     * setPathToExistingFileTestInstance() method.
     *
     * This method must also set the PathToExistingDirectory and Name
     * that are expected to be returned by the PathToExistingFile
     * being tested's pathToExistingDirectory() and name() methods,
     * respectively, via the setExpectedPathAndFileName() method.
     *
     * This method may also be used to perform any additional setup
     * required by the implementation being tested.
     *
     * @return void
     *
     * @example
     *
     * ```
     * public function setUp(): void
     * {
     *     $pathToExistingDirectory = new PathToExistingDirectory(
     *         $this->safeTextCollectionThatMapsToThePHPFileSystemPathsLibrarysTestsDirectory()
     *     );
     *     $nameOfFileThatExistsInThePHPFileSystemPathsTestsDirectory =
     *         $this->nameOfFileThatExistsInPHPFileSystemPathsTestsDirectory();
     *     $nameOfFileThatDoesNotExistInThePHPFileSystemPathsTestsDirectory =
     *         new Name(new Text($this->randomChars()));
     *     $testFileName = (
     *         rand(0, 1)
     *         ? $nameOfFileThatExistsInThePHPFileSystemPathsTestsDirectory
     *         : $nameOfFileThatDoesNotExistInThePHPFileSystemPathsTestsDirectory
     *     );
     *     $this->setExpectedPathAndFileName(
     *         $pathToExistingDirectory,
     *         $testFileName,
     *     );
     *     $this->setPathToExistingFileTestInstance(
     *         new PathToExistingFile($pathToExistingDirectory, $testFileName)
     *     );
     * }
     *
     * ```
     *
     */
    abstract protected function setUp(): void;

    /**
     * Return the PathToExistingFile implementation instance to test.
     *
     * @return PathToExistingFile
     *
     */
    protected function pathToExistingFileTestInstance(): PathToExistingFile
    {
        return $this->pathToExistingFile;
    }

    /**
     * Set the PathToExistingFile implementation instance to test.
     *
     * @param PathToExistingFile $pathToExistingFileTestInstance
     *                              An instance of an
     *                              implementation of
     *                              the PathToExistingFile
     *                              interface to test.
     *
     * @return void
     *
     */
    protected function setPathToExistingFileTestInstance(
        PathToExistingFile $pathToExistingFileTestInstance
    ): void
    {
        $this->pathToExistingFile = $pathToExistingFileTestInstance;
    }

    /*
     * Set the PathToExistingDirectory that is expected to
     * be returned by the PathToExistingFile being tested's
     * pathToExistingDirectory() method, as also set the
     * the Name that is expected to be returned by the
     * PathToExistingFile being tested's name() method.
     *
     * @param PathToExistingDirectory $pathToExistingDirectory
     *                                    the PathToExistingDirectory
     *                                    that is expected to be
     *                                    returned by the
     *                                    PathToExistingFile being
     *                                    tested's
     *                                    pathToExistingDirectory()
     *                                    method.
     *
     * @param Name $name The the Name that is expected to be returned
     *                   by the PathToExistingFile being tested's
     *                   name() method.
     *
     * @return void
     *
     */
    protected function setExpectedPathAndFileName(
        PathToExistingDirectory $pathToExistingDirectory,
        Name $name,
    ): void
    {
        if(!file_exists($pathToExistingDirectory . DIRECTORY_SEPARATOR . $name)) {
            $pathToExistingDirectory = new PathToExistingDirectoryInstance(
                $this->safeTextCollectionForPathToTmpDirectory()
            );
            $name = new NameInstance(new Text('PHPFileSystemPathsEmptyTmpFile'));
            $pathToTmpFile = $pathToExistingDirectory .
                DIRECTORY_SEPARATOR .
                $name->__toString();
            // Create tmp file every time to make sure it is always empty
            file_put_contents($pathToTmpFile, '', flags: LOCK_EX);
        }
        $this->setExpectedPathToExistingDirectory($pathToExistingDirectory);
        $this->setExpectedName($name);
    }

    /**
     * Set the PathToExistingDirectory that is expected to be
     * returned by the PathToExistingFile. being tested's
     * pathToExistingDirectory() method.
     *
     * @param PathToExistingDirectory  $pathToExistingDirectory
     *                                     The PathToExistingDirectory
     *                                     that is expected to be
     *                                     returned by the
     *                                     PathToExistingFile being
     *                                     tested's
     *                                     pathToExistingDirectory()
     *                                     method.
     *
     * @return void
     *
     */
    protected function setExpectedPathToExistingDirectory(PathToExistingDirectory $pathToExistingDirectory): void
    {
        $this->expectedPathToExistingDirectory = $pathToExistingDirectory;
    }

    /**
     * Return the PathToExistingDirectory that is expected to be
     * returned by the PathToExistingFile. being tested's
     * pathToExistingDirectory() method.
     *
     * @return PathToExistingDirectory
     *
     */
    protected function expectedPathToExistingDirectory(): PathToExistingDirectory
    {
        return $this->expectedPathToExistingDirectory;
    }

    /**
     * Set the Name that is expected to be
     * returned by the PathToExistingFile. being tested's
     * name() method.
     *
     * @param Name  $name
     *                                     The Name
     *                                     that is expected to be
     *                                     returned by the
     *                                     PathToExistingFile being
     *                                     tested's
     *                                     name()
     *                                     method.
     *
     * @return void
     *
     */
    protected function setExpectedName(Name $name): void
    {
        $this->expectedName = $name;
    }

    /**
     * Return the Name that is expected to be
     * returned by the PathToExistingFile. being tested's
     * name() method.
     *
     * @return Name
     *
     */
    protected function expectedName(): Name
    {
        return $this->expectedName;
    }

    /**
     * Test pathToExistingDirectory return expected PathToExistingDirectory.
     *
     * @return void
     *
     * @covers PathToExisitngFile->pathToExistingDirectory()
     *
     */
    public function test_pathToExistingDirectory_returns_expected_PathToExistingDirectory(): void
    {
        $this->assertEquals(
            $this->expectedPathToExistingDirectory(),
            $this->pathToExistingFileTestInstance()->pathToExistingDirectory(),
            $this->testFailedMessage(
                $this->pathToExistingFileTestInstance(),
                'pathToExistingDirectory',
                'return the expected PathToExistingDirectory instance.'
            ),
        );
    }

    /**
     * Test name return expected Name.
     *
     * @return void
     *
     * @covers PathToExisitngFile->name()
     *
     */
    public function test_name_returns_expected_Name(): void
    {
        $this->assertEquals(
            $this->expectedName(),
            $this->pathToExistingFileTestInstance()->name(),
            $this->testFailedMessage(
                $this->pathToExistingFileTestInstance(),
                'name',
                'return the expected Name instance.'
            ),
        );
    }

    /**
     * Test name return expected string.
     *
     * @return void
     *
     * @covers PathToExisitngFile->__toString()
     *
     */
    public function test___toString_returns_the_expected_string(): void
    {
        $this->assertEquals(
            $this->expectedPathToExistingDirectory()->__toString() . DIRECTORY_SEPARATOR . $this->expectedName()->__toString(),
            $this->pathToExistingFileTestInstance()->__toString(),
            $this->testFailedMessage(
                $this->pathToExistingFileTestInstance(),
                '__toString',
                'return the expected string.'
            ),
        );
    }

    /**
     * Test __toString() returns a path to an existing file.
     *
     * @return void
     *
     * @covers PathToExisitngFile->__toString()
     *
     */
    public function test___toString_returns_a_path_to_an_existing_file(): void
    {
        $this->assertTrue(
            file_exists($this->pathToExistingFileTestInstance()->__toString()),
            $this->testFailedMessage(
                $this->pathToExistingFileTestInstance(),
                '__toString',
                'return a path to an existing file.'
            ),
        );
    }
    abstract protected function testFailedMessage(object $testedInstance, string $testedMethod, string $expectation): string;
    abstract public function safeTextCollectionForPathToTmpDirectory(): SafeTextCollection;
    abstract public static function assertEquals(mixed $expected, mixed $actual, string $message = ''): void;
    abstract public static function assertTrue(mixed $condition, string $message = ''): void;

}

