<?php

namespace Darling\PHPFileSystemPaths\interfaces\paths;

use \Darling\PHPFileSystemPaths\interfaces\paths\PathToExistingDirectory;
use \Darling\PHPTextTypes\interfaces\strings\Name;
use \Stringable;

/**
 * A PathToExistingFile can be used when a path to an existing
 * file is required.
 *
 * The __toString() method can be used to obtain the path to the
 * file.
 *
 * If the assigned PathToExistingDirectory and Name can be mapped
 * to an existing file they will be used to construct the path
 * returned by the __toString() method.
 *
 * However, if the assigned PathToExistingDirectory and Name cannot be
 * mapped to an existing file then the __toString() method will return
 * the path to a temporary file in the directory whose path matches
 * the path returned by php's sys_get_temp_dir() function.
 *
 * The temporary file name will always be : PHPFileSystemPathsEmptyTmpFile
 *
 * The temporary file will be created if necessary.
 *
 */
interface PathToExistingFile extends Stringable
{

    /**
     * Return the PathToExisitingDirectory that defines the path where
     * the file is expected to be located.
     *
     * @return PathToExistingDirectory
     *
     */
    public function pathToExistingDirectory(): PathToExistingDirectory;

    /**
     * Return the Name of the file.
     *
     * @return Name
     *
     */
    public function name(): Name;


    /**
     * Return the path to the file.
     *
     * @return string
     *
     */
    public function __toString(): string;

}

