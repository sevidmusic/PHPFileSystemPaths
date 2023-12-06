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

    public function __construct(
        private PathToExistingDirectory $pathToExistingDirectory,
        private Name $name
    ) {
        $this->setPathAndFileName();
    }

    private function setPathAndFileName(): void
    {
        if(!file_exists($this->pathToExistingDirectory() . DIRECTORY_SEPARATOR . $this->name())) {
            $pathToExistingDirectory = new PathToExistingDirectoryInstance(
                $this->safeTextCollectionForPathToTmpDirectory()
            );
            $name = new NameInstance(new Text('PHPFileSystemPathsEmptyTmpFile'));
            $pathToTmpFile = $pathToExistingDirectory .
                DIRECTORY_SEPARATOR .
                $name->__toString();
            // Create tmp file every time to make sure it is always empty
            file_put_contents($pathToTmpFile, '', flags: LOCK_EX);
            $this->pathToExistingDirectory = $pathToExistingDirectory;
            $this->name = $name;
        }
    }

    /**
     * Return a SafeTextCollection that maps to the `/tmp` directory.
     *
     * @return SafeTextCollection
     *
     */
    public function safeTextCollectionForPathToTmpDirectory(): SafeTextCollection
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
    public function pathToExistingDirectory(): PathToExistingDirectory
    {
        return $this->pathToExistingDirectory;
    }

    public function name(): Name
    {
        return $this->name;
    }

}

