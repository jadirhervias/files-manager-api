<?php

namespace FilesManager\User\Domain;

interface UsersRepository
{
    public function save(User $user): void;

    public function findByEmail(string $email): ?User;
}
