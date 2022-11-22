<?php

namespace FilesManager\File\Application\Create;

use FilesManager\File\Domain\File;
use FilesManager\File\Domain\FilesRepository;
use FilesManager\Shared\Domain\Uuid;
use Illuminate\Support\Facades\Storage;

class FileCreator
{
    public function __construct(
        private readonly FilesRepository $repository,
    )
    {
    }

    public function __invoke(CreateFileRequest $request): File
    {
        $id = Uuid::random()->value();
        $upload = $request->upload();
        $root = 'files';
        $path = "$root/$id";

        Storage::putFileAs(
            $path,
            $request->upload()->file(),
            $upload->filename(),
            ['visibility' => 'public']
        );

        $file = File::create(
            $id,
            $upload->filename(),
            $upload->size(),
            $path,
            $upload->mimeType(),
        );

        $this->repository->save($file);

        return $file;
    }
}
