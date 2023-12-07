<?php

namespace Darling\PHPFileSystemPaths\tests\interfaces\paths;

use \Darling\PHPFileSystemPaths\interfaces\paths\PathToExistingDirectory;
use \Darling\PHPTextTypes\classes\collections\SafeTextCollection as SafeTextCollectionInstance;
use \Darling\PHPTextTypes\interfaces\collections\SafeTextCollection;

/**
 * The PathToExistingDirectoryTestTrait defines common tests for
 * implementations of the PathToExistingDirectory interface.
 *
 * @see PathToExistingDirectory
 *
 */
trait PathToExistingDirectoryTestTrait
{

    /**
     * @var PathToExistingDirectory $pathToExistingDirectory
     *                              An instance of a
     *                              PathToExistingDirectory
     *                              implementation to test.
     */
    protected PathToExistingDirectory $pathToExistingDirectory;

    /**
     * @var SafeTextCollection $expectedSafeTextCollection
     *                             The SafeTextCollection instances
     *                             that is expected to be returned by
     *                             the PathToExisitingDirectory being
     *                             tested's safeTextCollection()
     *                             method.
     */

    private SafeTextCollection $expectedSafeTextCollection;

    /**
     * Set up an instance of a PathToExistingDirectory implementation
     * to test.
     *
     * This method must set the PathToExistingDirectory
     * implementation instance to be tested via the
     * setPathToExistingDirectoryTestInstance() method.
     *
     * This method must also set the SafeTextCollection that defines
     * the parts of PathToAnExistingDirectory being tested's actual
     * path via the setExpectedSafeTextCollection() method.
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
     *     $safeTextCollectionForPathThatDoesNotExist =
     *         new SafeTextCollection(
     *             new SafeText(new Name(new Text($this->randomChars()))),
     *             new SafeText(new Name(new Text($this->randomChars()))),
     *             new SafeText(new Name(new Text($this->randomChars()))),
     *         );
     *     $currentDirectoryPathParts = explode(
     *         DIRECTORY_SEPARATOR,
     *         __DIR__
     *     );
     *     $safeTextPartsToExistingDirectoryPath = [];
     *     foreach($currentDirectoryPathParts as $pathPart) {
     *         if(!empty($pathPart)) {
     *             $safeTextPartsToExistingDirectoryPath[] =
     *                 new SafeText(
     *                     new Name(new Text($pathPart))
     *                 );
     *         }
     *     }
     *     $safeTextColletionForPathThatDoesExist =
     *         new SafeTextCollection(
     *             ...$safeTextPartsToExistingDirectoryPath
     *         );
     *     $testSafeTextCollection = (
     *         rand(0, 1)
     *         ? $safeTextCollectionForPathThatDoesNotExist
     *         : $safeTextColletionForPathThatDoesExist
     *     );
     *     $this->setExpectedSafeTextCollection($testSafeTextCollection);
     *     $this->setPathToExistingDirectoryTestInstance(
     *         new PathToExistingDirectory($testSafeTextCollection)
     *     );
     * }
     *
     * ```
     *
     */
    abstract protected function setUp(): void;

    /**
     * Return the PathToExistingDirectory implementation instance to
     * test.
     *
     * @return PathToExistingDirectory
     *
     */
    protected function pathToExistingDirectoryTestInstance(): PathToExistingDirectory
    {
        return $this->pathToExistingDirectory;
    }

    /**
     * Set the PathToExistingDirectory implementation instance to test.
     *
     * @param PathToExistingDirectory $pathToExistingDirectoryTestInstance
     *                                    An instance of an
     *                                    implementation of
     *                                    the PathToExistingDirectory
     *                                    interface to test.
     *
     * @return void
     *
     */
    protected function setPathToExistingDirectoryTestInstance(
        PathToExistingDirectory $pathToExistingDirectoryTestInstance
    ): void
    {
        $this->pathToExistingDirectory = $pathToExistingDirectoryTestInstance;
    }

    /**
     * Set the SafeTextCollection that is expected to be returned by
     * the PathToExisitingDirectory being tested's safeTextCollection()
     * method.
     *
     * @param SafeTextCollection $safeTextCollection
     *                               The SafeTextCollection that is
     *                               expected to be returned by the
     *                               PathToExisitingDirectory being
     *                               tested's safeTextCollection()
     *                               method.
     *
     * @rerturn void
     *
     */
    protected function setExpectedSafeTextCollection(
        SafeTextCollection $safeTextCollection
    ): void
    {
        $this->expectedSafeTextCollection = match(
            $this->safeTextCollectionMapsToAnExistingPath($safeTextCollection)
        ) {
            true =>  $safeTextCollection,
            false => $this->safeTextCollectionForPathToTmpDirectory(),
        };
    }

    /**
     * Returns true the specified SafeTextCollection can be mapped to
     * an existing directory path, false otherwise.
     *
     * @param SafeTextCollection $safeTextCollection
     *                               The SafeTextCollection to test.
     *
     * @return bool
     *
     */
    private function safeTextCollectionMapsToAnExistingPath(
        SafeTextCollection $safeTextCollection
    ): bool
    {
        return is_dir(
            $this->derivePathFromSafeTextCollection(
                $safeTextCollection
            )
        );
    }

    /**
     * Derive a path from a specified SafeTextCollection.
     *
     * @param SafeTextCollection $safeTextCollection
     *                               The SafeTextCollection
     *                               to derive a path from.
     *
     * @return string
     *
     */
    private function derivePathFromSafeTextCollection(
        SafeTextCollection $safeTextCollection
    ): string
    {
        $pathDerivedFromSafeTextCollection = '';
        foreach($safeTextCollection->collection() as $safeText) {
            $pathDerivedFromSafeTextCollection .=
                DIRECTORY_SEPARATOR . $safeText->__toString();
        }
        return $pathDerivedFromSafeTextCollection;
    }

    /**
     * Return the SafeTextCollection that is expected to be
     * returned by the PathToExisitingDirectory being tested's
     * safeTextCollection() method.
     *
     * @rerturn void
     *
     */
    protected function expectedSafeTextCollection(): SafeTextCollection
    {
        return $this->expectedSafeTextCollection;
    }


    /**
     * Test safeTextCollection returns the expected SafeTextCollection.
     *
     * @return void
     *
     * @covers PathToExisitngDirectory->safeTextCollection()
     *
     */
    public function test_safeTextCollection_returns_the_expected_SafeTextCollection(): void
    {
        $this->assertEquals(
            $this->expectedSafeTextCollection(),
            $this->pathToExistingDirectoryTestInstance()->safeTextCollection(),
            $this->testFailedMessage(
                $this->pathToExistingDirectoryTestInstance(),
                'safeTextCollection',
                'return the expected SafeTextCollection'
            ),
        );
    }

    /**
     * Test __toString() returns a path derived from the expected
     * SafeTextCollection.
     *
     * @return void
     *
     * @covers PathToExisitngDirectory->__toString()
     *
     */
    public function test___toString_returns_a_path_derived_from_the_expected_SafeTextCollection(): void
    {
        $this->assertEquals(
            $this->derivePathFromSafeTextCollection($this->expectedSafeTextCollection()),
            $this->pathToExistingDirectoryTestInstance()->__toString(),
            $this->testFailedMessage(
                $this->pathToExistingDirectoryTestInstance(),
                '__toString',
                'return the path derived from the expected SafeTextCollection'
            ),
        );
    }

    /**
     * Test __toString() returns a path to an existing directory.
     * @return void
     *
     * @covers PathToExisitngDirectory->__toString()
     *
     */
    public function test___toString_returns_a_path_to_an_existing_directory(): void
    {
        $this->assertTrue(
            is_dir($this->pathToExistingDirectoryTestInstance()->__toString()),
            $this->testFailedMessage(
                $this->pathToExistingDirectoryTestInstance(),
                '__toString',
                'return a path to an exisiting directory'
            ),
        );
    }

    abstract protected function testFailedMessage(object $testedInstance, string $testedMethod, string $expectation): string;
    abstract public static function assertEquals(mixed $expected, mixed $actual, string $message = ''): void;
    abstract public static function assertTrue(mixed $condition, string $message = ''): void;

}

