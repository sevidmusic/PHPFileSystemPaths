<?php

namespace Darling\PHPFileSystemPaths\classes\paths;

use Darling\PHPTextTypes\interfaces\collections\SafeTextCollection;
use \Darling\PHPFileSystemPaths\interfaces\paths\PathToExistingDirectory as PathToExistingDirectoryInterface;
use \Darling\PHPTextTypes\classes\collections\SafeTextCollection as SafeTextCollectionInstance;
use \Darling\PHPTextTypes\classes\strings\SafeText;
use \Darling\PHPTextTypes\classes\strings\Text;

class PathToExistingDirectory implements PathToExistingDirectoryInterface
{


    /**
     * Instantiate a new PathToExistingDirectory.
     *
     * @param SafeTextCollection $safeTextCollection
     *                               The SafeTextCollection that will
     *                               be used to construct the path to
     *                               the existing directory.
     *
     *                               Note: If the specified
     *                               SafeTextCollection does
     *                               not map to an existing
     *                               directory then the
     *                               path returned by the
     *                               __toString() method will
     *                               be the path to the systems
     *                               temporary directory.
     *
     *                               The temporary directory
     *                               path will be determined
     *                               via php's sys_get_temp_dir()
     *                               function.
     *
     * @see [sys_get_temp_dir()](https://www.php.net/manual/en/function.sys-get-temp-dir.php)
     *
     */
    public function __construct(
        private SafeTextCollection $safeTextCollection
    ) {
        if(
            !$this->safeTextCollectionMapsToAnExistingPath(
                $this->safeTextCollection
            )
        ) {
            $this->safeTextCollection =
                $this->safeTextCollectionForPathToTmpDirectory();
        }
    }

    public function safeTextCollection(): SafeTextCollection
    {
        return $this->safeTextCollection;
    }

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

    private function safeTextCollectionForPathToTmpDirectory(): SafeTextCollection
    {
        return new SafeTextCollectionInstance(
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

    public function __toString(): string
    {
        return $this->derivePathFromSafeTextCollection(
            $this->safeTextCollection()
        );
    }

}

