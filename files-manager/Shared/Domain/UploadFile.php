<?php

namespace FilesManager\Shared\Domain;

use DateTimeImmutable;
use LogicException;
use Illuminate\Http\File as SymfonyFile;
use Illuminate\Http\UploadedFile as SymfonyUploadedFile;

class UploadFile
{
    private string $filename;
    private ?string $contents = null;
    private int $size;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;
    private SymfonyFile|SymfonyUploadedFile|null $file;

    private function __construct(
        string                               $filename,
        string                               $contents,
        SymfonyFile|SymfonyUploadedFile|null $file = null
    )
    {
        $this->filename = $filename;
        $this->setContents($contents);
        $this->createdAt = EnhancedDateTime::now()->value();
        $this->updatedAt = $this->createdAt;
        $this->file = $file;
    }

    public static function create(
        string                               $filename,
        string                               $contents,
        SymfonyFile|SymfonyUploadedFile|null $file = null
    ): self
    {
        return new self($filename, $contents, $file);
    }

    public static function fromFile(SymfonyFile|SymfonyUploadedFile $file): self
    {
        return self::create($file->getClientOriginalName(), $file->getContent(), $file);
    }

    public function filename(): string
    {
        return $this->filename;
    }

    public function contents(): string
    {
        if (is_null($this->contents)) {
            throw new LogicException(sprintf(
                'The contents of file <%s> have not been loaded yet.',
                $this->filename
            ));
        }

        return $this->contents;
    }

    /**
     * @return int File size in bytes
     */
    public function size(): int
    {
        return $this->size;
    }

    public function extension(): string
    {
        $filenameExplosion = \explode('.', $this->filename);
        return \end($filenameExplosion);
    }

    public function mimeType(): string
    {
        return MimeType::fromFilename($this->filename);
    }

    public function createdAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function file(): SymfonyFile|SymfonyUploadedFile|null
    {
        return $this->file;
    }
}
