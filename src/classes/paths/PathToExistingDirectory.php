<?php

namespace Darling\PHPFileSystemPaths\classes\paths;

use Darling\PHPTextTypes\interfaces\collections\SafeTextCollection;
use \Darling\PHPFileSystemPaths\interfaces\paths\PathToExistingDirectory as PathToExistingDirectoryInterface;
use \Darling\PHPTextTypes\classes\collections\SafeTextCollection as SafeTextCollectionInstance;
use \Darling\PHPTextTypes\classes\strings\SafeText;
use \Darling\PHPTextTypes\classes\strings\Text;

class PathToExistingDirectory implements PathToExistingDirectoryInterface
{


    public function __construct(
        private SafeTextCollection $safeTextCollection
    ) {
        if(!$this->safeTextCollectionMapsToAnExistingPath($this->safeTextCollection)) {
            $this->safeTextCollection = $this->safeTextCollectionForPathToTmpDirectory();
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
            new SafeText(new Text('tmp'))
        );
    }


    public function __toString(): string
    {
        return $this->derivePathFromSafeTextCollection(
            $this->safeTextCollection()
        );
    }
}

