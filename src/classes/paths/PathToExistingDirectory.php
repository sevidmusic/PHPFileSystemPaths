<?php

namespace Darling\PHPFileSystemPaths\classes\paths;

use \Darling\PHPFileSystemPaths\interfaces\paths\PathToExistingDirectory as PathToExistingDirectoryInterface;
use \Darling\PHPTextTypes\classes\collections\SafeTextCollection as SafeTextCollectionInstance;
use \Darling\PHPTextTypes\classes\strings\SafeText;
use \Darling\PHPTextTypes\classes\strings\Text;
use \Darling\PHPTextTypes\interfaces\collections\SafeTextCollection;

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
     *                               directory then a
     *                               SafeTextCollection will
     *                               be instantiated internally
     *                               that will map to the systems
     *                               temporary directory to make
     *                               sure the path returned by the
     *                               __toString() method is a path
     *                               an existing directory.
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

    public function __toString(): string
    {
        return $this->derivePathFromSafeTextCollection(
            $this->safeTextCollection()
        );
    }

    public function safeTextCollection(): SafeTextCollection
    {
        return $this->safeTextCollection;
    }

    /**
     * Determine if the specified SafeTextCollection maps to an
     * existing path.
     *
     * @param SafeTextCollection $safeTextCollection
     *                               The SafeTextCollection
     *                               to check.
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
     * Derive a path from a SafeTextCollection.
     *
     * @param SafeTextCollection $safeTextCollection
     *                               The SafeTextCollection
     *                               to derive a path from.
     *
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
     * Return a SafeTextCollection that maps to thhe systems
     * temporary directory.
     *
     * @return SafeTextCollection
     *
     */
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

}

