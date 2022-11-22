<?php

namespace FilesManager\File\Domain;

interface FilesRepository
{
    public function save(File $file): void;

    /**
     * @return File[]
     */
    public function findAll(): array;

    public function findById(string $id): ?File;

    public function delete(string $id): void;
}
