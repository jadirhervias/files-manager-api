<?php

namespace FilesManager\File\Application\Delete;

use FilesManager\File\Domain\FileNotExists;
use FilesManager\File\Domain\FilesRepository;
use Illuminate\Support\Facades\Storage;

class FileDeleter
{
    public function __construct(
        private readonly FilesRepository $repository,
    )
    {
    }

    public function __invoke(DeleteFileRequest $request)
    {
        $id = $request->id();
        $basePath = 'files';
        $path = "$basePath/$id";

        $file = $this->repository->findById($id);

        if (null === $file) {
            throw new FileNotExists($id);
        }

        if ($request->permanent()) {
            $this->repository->delete($id);
            Storage::delete("$path/{$file->filename()}");
            Storage::deleteDirectory($path);
            return;
        }

        $file->makeHiden();
        $this->repository->save($file);
    }
}
