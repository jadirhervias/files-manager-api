<?php

namespace FilesManager\File\Domain;

use FilesManager\Shared\Domain\DomainError;

class FileSizeExceedsLimit extends DomainError
{
    public function errorCode(): int
    {
        return 101;
    }

    public function errorMessage(): string
    {
        return sprintf('File size exceeds the limit of <%d> bytes.', File::MAX_BYTES);
    }
}
