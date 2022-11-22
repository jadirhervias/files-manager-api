<?php

namespace FilesManager\Shared\Domain;

use DomainException;

abstract class DomainError extends DomainException
{
    public function __construct()
    {
        parent::__construct(
            $this->errorMessage(),
            $this->errorCode(),
        );
    }

    public function errorName(): string
    {
        return strtoupper(Utils::toSnakeCase(__CLASS__));
    }

    abstract public function errorCode(): int;

    abstract public function errorMessage(): string;
}
