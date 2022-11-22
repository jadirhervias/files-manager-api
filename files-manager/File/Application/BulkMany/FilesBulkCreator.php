<?php

namespace FilesManager\File\Application\BulkMany;

use FilesManager\File\Domain\File;
use FilesManager\File\Domain\FilesRepository;
use FilesManager\Shared\Domain\UploadFile;
use FilesManager\Shared\Domain\Uuid;
use Illuminate\Support\Facades\Storage;

class FilesBulkCreator
{
    public function __construct(
        private readonly FilesRepository $repository,
    )
    {
    }

    public function __invoke(BulkFilesRequest $request): BulkFilesResponse
    {
        $totalUploadedFiles = 0;
        $totalRejectedFiles = 0;
        $files = [];

        collect($request->uploads())
            ->chunkWhile(function (UploadFile $upload) use (
                &$totalRejectedFiles,
                &$totalUploadedFiles,
                &$files
            ) {
                $id = Uuid::random()->value();
                $root = 'files';
                $path = "$root/$id";

                $file = File::create(
                    $id,
                    $upload->filename(),
                    $upload->size(),
                    $path,
                    $upload->mimeType(),
                );

                if ($file->exceedsMaxSize()) {
                    $totalRejectedFiles++;
                }

                Storage::putFileAs(
                    $path,
                    $upload->file(),
                    $upload->filename(),
                    ['visibility' => 'public']
                );

                $totalUploadedFiles++;

                $files[] = $file;
            });

        $this->repository->insertMany($files);

        return new BulkFilesResponse($totalUploadedFiles, $totalRejectedFiles);
    }
}
