<?php

namespace Darling\PHPFileSystemPaths\classes\paths;

use \Darling\PHPFileSystemPaths\classes\paths\PathToExistingDirectory as PathToExistingDirectoryInstance;
use \Darling\PHPFileSystemPaths\interfaces\paths\PathToExistingDirectory;
use \Darling\PHPFileSystemPaths\interfaces\paths\PathToExistingFile as PathToExistingFileInterface;
use \Darling\PHPTextTypes\classes\collections\SafeTextCollection;
use \Darling\PHPTextTypes\classes\strings\Name as NameInstance;
use \Darling\PHPTextTypes\classes\strings\SafeText;
use \Darling\PHPTextTypes\classes\strings\Text;
use \Darling\PHPTextTypes\interfaces\strings\Name;

class PathToExistingFile implements PathToExistingFileInterface
{

    /**
     * @const string TMP_FILE_NAME Name assigned to the temporary file
     *                             created if a file whose name matches
     *                             the Name passed to to __construct()
     *                             method does not exist in the
     *                             PathToExisitingDirectory passed to
     *                             the __construct() method.
     */
    private const TMP_FILE_NAME = 'PHPFileSystemPathsEmptyTmpFile';

    /**
     * Instantiate a new PathToExisting directory.
     *
     * Note:
     *
     * A PathToExisitngFile's __toString() method must always return
     * a path to an existing file.
     *
     * This means that the path returned by the __toString() method
     * may not match the path that correlates to the specified
     * $pathToExistingDirectory  and $name.
     *
     * If a file whose name matches the specified $name exists
     * in the specified $pathToExistingDirectory then the path
     * returned by the __toString() method will be the path to that
     * file.
     *
     * However, if a file whose name matches the specified $name does
     * not exist in the specified $pathToExistingDirectory then the
     * specified a $pathToExistingDirectory and $name will be ignored,
     * and a new PathToExistingDirectory instance and a new Name
     * instance will be instantiated internally that collectively form
     * a path to a temporary file in the systems temporary directory.
     * If the temporary file does not exist, it will be created.
     *
     * This is to insure that the path returned by __toString() always
     * points to an existing file.
     *
     * The temporary file's name will alays be:
     *
     *     PHPFileSystemPathsEmptyTmpFile
     *
     * @param PathToExistingDirectory $pathToExistingDirectory
     *                                The path to the directory where
     *                                the file is located.
     *
     * @param Name $name The name of the file. (see note above)
     *
     */
    public function __construct(
        private PathToExistingDirectory $pathToExistingDirectory,
        private Name $name
    ) {
        $this->resetPathAndFileNameIfSpecifiedFileDoesNotExist();
    }

    public function pathToExistingDirectory(): PathToExistingDirectory
    {
        return $this->pathToExistingDirectory;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return $this->pathToExistingDirectory()->__toString() .
            DIRECTORY_SEPARATOR .
            $this->name()->__toString();
    }

    /**
     * Return a SafeTextCollection that maps to the `/tmp` directory.
     *
     * @return SafeTextCollection
     *
     */
    private function safeTextCollectionForPathToTmpDirectory(): SafeTextCollection
    {
        return new SafeTextCollection(
            new SafeText(
                new Text(
                    str_replace(
                        DIRECTORY_SEPARATOR,
                        '',
                        sys_get_temp_dir()
                    )
                )
            )
        );
    }

    /**
     * Reset the assigned PathToExistingDirectoryInstance and Name if
     * they do not correlate to a path to an existing file.
     *
     * @return void
     *
     */
    private function resetPathAndFileNameIfSpecifiedFileDoesNotExist(): void
    {
        if(
            !file_exists(
                $this->pathToExistingDirectory() .
                DIRECTORY_SEPARATOR .
                $this->name()
            )
        ) {
            $pathToExistingDirectory = new PathToExistingDirectoryInstance(
                $this->safeTextCollectionForPathToTmpDirectory()
            );
            $name = new NameInstance(new Text(self::TMP_FILE_NAME));
            $pathToTmpFile = $pathToExistingDirectory .
                DIRECTORY_SEPARATOR .
                $name->__toString();
            // Create tmp file every time to make sure it is always empty
            file_put_contents($pathToTmpFile, '', flags: LOCK_EX);
            $this->pathToExistingDirectory = $pathToExistingDirectory;
            $this->name = $name;
        }
    }

}

