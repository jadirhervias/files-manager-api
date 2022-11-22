<?php

namespace FilesManager\File\Application\BulkMany;

class BulkFilesResponse
{
    /**
     * @param int $totalUploaded
     * @param int $totalRejected
     */
    public function __construct(
        private readonly int $totalUploaded,
        private readonly int $totalRejected,
    )
    {
    }

    public function totalUploaded(): int
    {
        return $this->totalUploaded;
    }

    public function totalRejected(): int
    {
        return $this->totalRejected;
    }
}
