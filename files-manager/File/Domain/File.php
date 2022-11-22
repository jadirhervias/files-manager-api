<?php

namespace FilesManager\File\Domain;

use FilesManager\Shared\Domain\AggregateRoot;
use FilesManager\Shared\Domain\EnhancedDateTime;

class File extends AggregateRoot
{
    public function __construct(
        private readonly string  $id,
        private readonly string  $filename,
        private readonly int     $size,
        private readonly string  $path,
        private readonly string  $mimeType,
        private FileStatuses     $status,
        private readonly ?string $createdAt,
        private readonly ?string $updatedAt,
        private ?string          $deletedAt,
    )
    {
    }

    public static function create(
        string        $id,
        string        $filename,
        int           $size,
        string        $path,
        string        $mimeType,
        ?FileStatuses $status = null,
    ): File
    {
        $fileStatus = $status ?? FileStatuses::VISIBLE;
        $now = EnhancedDateTime::now()->format();

        return new self(
            $id,
            $filename,
            $size,
            $path,
            $mimeType,
            $fileStatus,
            $now,
            $now,
            $fileStatus->is(FileStatuses::HIDDEN) ? $now : null,
        );
    }

    public function id(): string
    {
        return $this->id;
    }

    public function filename(): string
    {
        return $this->filename;
    }

    public function size(): int
    {
        return $this->size;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function mimeType(): string
    {
        return $this->mimeType;
    }

    public function status(): FileStatuses
    {
        return $this->status;
    }

    public function makeVisible(): void
    {
        $this->status = FileStatuses::VISIBLE;
    }

    public function makeHiden(): void
    {
        $this->deletedAt = EnhancedDateTime::now()->format();
        $this->status = FileStatuses::HIDDEN;
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id,
            'filename' => $this->filename,
            'size' => $this->size,
            'path' => $this->path,
            'mime_type' => $this->mimeType,
            'status' => $this->status->value,
            'deleted_at' => $this->deletedAt,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
