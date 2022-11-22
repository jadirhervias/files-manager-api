<?php

namespace FilesManager\File\Domain;

use FilesManager\Shared\Domain\DomainError;

class FileNotExists extends DomainError
{
    public function __construct(private string $id)
    {
        parent::__construct();
    }

    public function errorCode(): int
    {
        return 100;
    }

    public function errorMessage(): string
    {
        return sprintf('File with ID <%s> not exists', $this->id);
    }
}
