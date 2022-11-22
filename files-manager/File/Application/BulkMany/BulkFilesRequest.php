<?php

namespace FilesManager\File\Application\BulkMany;

use FilesManager\Shared\Domain\UploadFile;

class BulkFilesRequest
{
    /**
     * @param UploadFile[] $uploadFiles
     */
    public function __construct(
        private readonly array $uploadFiles,
    )
    {
    }

    /**
     * @return UploadFile[]
     */
    public function uploads(): array
    {
        return $this->uploadFiles;
    }
}
