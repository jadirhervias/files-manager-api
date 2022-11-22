<?php

namespace FilesManager\File\Infrastructure\Persistence\Eloquent;

use App\Models\File as FileEloquentModel;
use FilesManager\File\Domain\File;
use FilesManager\File\Domain\FilesRepository;
use FilesManager\File\Domain\FileStatuses;
use FilesManager\Shared\Domain\AggregateRoot;
use FilesManager\Shared\Infrastructure\Persistence\Eloquent\EloquentRepository;

class EloquentFilesRepository extends EloquentRepository implements FilesRepository
{
    function serializer($attributes): AggregateRoot
    {
        return new File(
            $attributes['id'],
            $attributes['filename'],
            $attributes['size'],
            $attributes['path'],
            $attributes['mime_type'],
            FileStatuses::from($attributes['status']),
            $attributes['created_at'],
            $attributes['updated_at'],
            $attributes['deleted_at']
        );
    }

    function modelClass(): string
    {
        return FileEloquentModel::class;
    }

    public function save(File $file): void
    {
        $this->persist($file);
    }

    /**
     * @return File[]
     */
    public function findAll(): array
    {
        return $this->all();
    }

    public function findById(string $id): ?File
    {
        return $this->find($id);
    }

    public function delete(string $id): void
    {
        $this->remove($id);
    }
}
