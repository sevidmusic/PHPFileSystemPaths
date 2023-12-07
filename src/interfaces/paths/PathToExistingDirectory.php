<?php

namespace Darling\PHPFileSystemPaths\interfaces\paths;

use \Darling\PHPTextTypes\interfaces\collections\SafeTextCollection;
use \Stringable;

/**
 * A PathToExisitingDirectory can be used when a path to an existing
 * directory is required.
 *
 * The __toString() method can be used to obtain the path to the
 * directory.
 *
 * If the assigned SafeTextCollection can be mapped to an existing
 * directory it will be used to construct the path returned
 * by the __toString() method.
 *
 * However, if the assigned SafeTextCollection cannot be mapped to an
 * existing directory then the __toString() method will return the
 * path returned by php's sys_get_temp_dir() function.
 *
 */
interface PathToExistingDirectory extends Stringable
{

    /**
     * Return the SafeTextCollection that defines the parts of this
     * PathToExistingDirectory.
     *
     * @return SafeTextCollection
     *
     */
    public function safeTextCollection(): SafeTextCollection;


    /**
     * Return the path to the existing directory.
     *
     * @return string
     *
     */
    public function __toString(): string;

}

