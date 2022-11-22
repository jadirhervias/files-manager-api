<?php

namespace FilesManager\User\Domain;

use FilesManager\Shared\Domain\AggregateRoot;
use FilesManager\Shared\Domain\EnhancedDateTime;

class User extends AggregateRoot
{
    public function __construct(
        private readonly string  $id,
        private readonly string  $name,
        private readonly string  $email,
        private readonly string  $password,
        private readonly ?string $createdAt,
        private readonly ?string $updatedAt,
    )
    {
    }

    public static function create(
        string $id,
        string $name,
        string $email,
        string $password,
    ): User
    {
        $now = EnhancedDateTime::now()->format();
        return new self(
            $id,
            $name,
            $email,
            $password,
            $now,
            $now,
        );
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
