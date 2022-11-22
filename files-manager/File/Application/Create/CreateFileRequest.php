<?php

namespace FilesManager\File\Application\Create;

use FilesManager\Shared\Domain\UploadFile;

class CreateFileRequest
{
    public function __construct(
        private readonly UploadFile $uploadFile,
    )
    {
    }

    public function upload(): UploadFile
    {
        return $this->uploadFile;
    }
}
