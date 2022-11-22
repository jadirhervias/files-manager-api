<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use FilesManager\File\Application\Create\CreateFileRequest;
use FilesManager\File\Application\Create\FileCreator;
use FilesManager\Shared\Domain\UploadFile;
use Illuminate\Http\Request;

class FileBulkPostController extends Controller
{
    public function __construct(private readonly FileCreator $creator)
    {
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return void
     * @throws \Throwable
     */
    public function __invoke(Request $request): void
    {
        if (!$request->hasFile('file')) {
            return;
        }

        $uploads = $request->allFiles()['file'];

        collect($uploads)
            ->chunkWhile(function (\Illuminate\Http\UploadedFile $upload) {
                $this->creator->__invoke(new CreateFileRequest(
                    UploadFile::fromFile($upload)
                ));
            });
    }
}
