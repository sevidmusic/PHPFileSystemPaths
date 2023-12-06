<?php

namespace Darling\PHPFileSystemPaths\classes\paths;

use \Darling\PHPFileSystemPaths\interfaces\paths\PathToExistingFile as PathToExistingFileInterface;
use \Darling\PHPFileSystemPaths\interfaces\paths\PathToExistingDirectory;
use \Darling\PHPTextTypes\interfaces\strings\Name;

class PathToExistingFile implements PathToExistingFileInterface
{

    public function __construct(
        private PathToExistingDirectory $pathToExistingDirectory,
        private Name $name
    ) { }

    public function pathToExistingDirectory(): PathToExistingDirectory
    {
        return $this->pathToExistingDirectory;
    }

    public function name(): Name
    {
        return $this->name;
    }

}

