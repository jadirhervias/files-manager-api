<?php

namespace FilesManager\User\Application\Create;

class CreateUserRequest
{
    public function __construct(
        private readonly string $name,
        private readonly string $email,
        private readonly string $hashedPassword,
    )
    {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function hashedPassword(): string
    {
        return $this->hashedPassword;
    }
}
