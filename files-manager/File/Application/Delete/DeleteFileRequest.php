<?php

namespace FilesManager\File\Application\Delete;

class DeleteFileRequest
{
    public function __construct(
        private string $id,
        private bool   $permanent,
    )
    {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function permanent(): bool
    {
        return $this->permanent;
    }
}
