<?php

namespace FilesManager\File\Application\Find;

use FilesManager\File\Domain\File;
use FilesManager\File\Domain\FilesRepository;

class FileFinder
{
    public function __construct(
        private readonly FilesRepository $repository,
    )
    {
    }

    /**
     * @return File[]
     */
    public function __invoke(): array
    {
        return $this->repository->findAll();
    }
}
