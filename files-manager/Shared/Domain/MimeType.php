<?php

namespace FilesManager\Shared\Domain;

use Illuminate\Http\Testing\MimeType as SymfonyMimeType;

class MimeType
{
    public static function fromFilename($filename): string
    {
        return SymfonyMimeType::from($filename);
    }

    /**
     * @param string $ext
     * @param bool $justOne
     * @return string|string[]
     */
    public static function fromExtension(string $ext, bool $justOne = true): array|string
    {
        if ($justOne) {
            return SymfonyMimeType::get($ext);
        }

        return SymfonyMimeType::getMimeTypes()->getMimeTypes($ext);
    }

    /**
     * @param string $mimeType
     * @return string|string[]
     */
    public static function getExtensions(string $mimeType): array|string
    {
        return SymfonyMimeType::getMimeTypes()->getExtensions($mimeType);
    }
}
