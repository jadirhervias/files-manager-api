<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use FilesManager\File\Application\Create\CreateFileRequest;
use FilesManager\File\Application\Create\FileCreator;
use FilesManager\Shared\Domain\UploadFile;
use Illuminate\Http\JsonResponse;
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
     * @return JsonResponse
     * @throws \Throwable
     */
    public function __invoke(Request $request): JsonResponse
    {
        $uploads = $request->allFiles()['file'];

        collect($uploads)
            ->chunkWhile(function (\Illuminate\Http\UploadedFile $upload) {
                $this->creator->__invoke(new CreateFileRequest(
                    UploadFile::fromFile($upload)
                ));
            });

        return response()->json([
            'message' => 'Files uploaded successfully'
        ], JsonResponse::HTTP_OK);
    }
}
