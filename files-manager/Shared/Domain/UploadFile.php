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
    private string $contentHash;
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

    private function setContents(string $contents): void
    {
        $this->contentHash = $this->hashContents($contents);
        $this->size = \strlen($contents);
        $this->contents = $contents;
        $this->updatedAt = EnhancedDateTime::now()->value();
    }

    private function hashContents(string $contents): string
    {
        return \sha1($contents);
    }

    public function filename(): string
    {
        return $this->filename;
    }

    public function contents(): string
    {
        if (null === $this->contents) {
            throw new LogicException(sprintf(
                'The contents of file <%s> have not been loaded yet.',
                $this->filename
            ));
        }

        return $this->contents;
    }

    public function contentHash(): string
    {
        return $this->contentHash;
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

    public function load(string $contents): self
    {
        if ($this->hashContents($contents) !== $this->contentHash) {
            $newHash = $this->hashContents($contents);
            throw new LogicException(sprintf(
                "Attempted to load file '<%s>' with contents that do not match the file\\'s content hash '<%s>'. Hash of supplied contents: '<%s>'.",
                $this->filename,
                $this->contentHash,
                $newHash
            ));
        }

        $this->contents = $contents;
        return $this;
    }

    public function rename(string $newFilename): self
    {
        if ($this->filename === $newFilename) {
            return $this;
        }

        $this->filename = $newFilename;
        $this->updatedAt = EnhancedDateTime::now()->value();

        return $this;
    }

    public function updateContents(string $newContents): self
    {
        if ($this->contentHash === $this->hashContents($newContents)) {
            return $this;
        }

        $this->setContents($newContents);

        return $this;
    }
}
