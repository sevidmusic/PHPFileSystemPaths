<?php

namespace Darling\PHPFileSystemPaths\interfaces\paths;

use Darling\PHPTextTypes\interfaces\strings\Name;
use \Darling\PHPFileSystemPaths\interfaces\paths\PathToExistingDirectory;

/**
 * Description of this interface.
 *
 * @example
 *
 * ```
 *
 * ```
 */
interface PathToExistingFile
{

    public function pathToExistingDirectory(): PathToExistingDirectory;

    public function name(): Name;

}

