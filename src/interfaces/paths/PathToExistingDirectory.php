<?php

namespace Darling\PHPFileSystemPaths\interfaces\paths;

use Darling\PHPTextTypes\interfaces\collections\SafeTextCollection;
use \Stringable;

/**
 * Description of this interface.
 *
 * @example
 *
 * ```
 *
 * ```
 */
interface PathToExistingDirectory extends Stringable
{

    /**
     * Return the SafeTextCollection that defines the parts of this
     * PathToAnExistingDirectory.
     *
     * @return SafeTextCollection
     *
     */
    public function safeTextCollection(): SafeTextCollection;


    /**
     * Return the path to the existing directory as a string.
     * This path will be derived from SafeTextCollection assigned
     * to the PathToExisitingDirectory.
     *
     * @return string
     *
     */
    public function __toString(): string;

}

