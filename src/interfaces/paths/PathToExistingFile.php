<?php

namespace Darling\PHPFileSystemPaths\interfaces\paths;

use \Darling\PHPTextTypes\interfaces\strings\Name;
use \Darling\PHPFileSystemPaths\interfaces\paths\PathToExistingDirectory;
use \Stringable;

/**
 * Defines a path to an existing file.
 *
 * By default this path will point to a temporary file that will
 * be created if necessary to ensure that a PathToexistingFile
 * always points to an existing file.
 *
 * The default path will be: /tmp/PHPFileSystemPathsEmptyTmpFile
 *
 */
interface PathToExistingFile extends Stringable
{

    public function pathToExistingDirectory(): PathToExistingDirectory;

    public function name(): Name;

    public function __toString(): string;

}

