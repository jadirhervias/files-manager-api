<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileBulkPostRequest;
use FilesManager\File\Application\Create\CreateFileRequest;
use FilesManager\File\Application\Create\FileCreator;
use FilesManager\File\Domain\FileSizeExceedsLimit;
use FilesManager\Shared\Domain\UploadFile;
use Illuminate\Http\JsonResponse;

class FileBulkPostController extends Controller
{
    public function __construct(private readonly FileCreator $creator)
    {
    }

    /**
     * Handle the incoming request.
     *
     * @param FileBulkPostRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function __invoke(FileBulkPostRequest $request): JsonResponse
    {
        $uploads = $request->allFiles()['files'];
        $totalUploadedFiles = 0;
        $totalRejectedFiles = 0;

        collect($uploads)
            ->chunkWhile(function (\Illuminate\Http\UploadedFile $upload) use (
                &$totalRejectedFiles,
                &$totalUploadedFiles
            ) {
                try {
                    $this->creator->__invoke(new CreateFileRequest(
                        UploadFile::fromFile($upload)
                    ));
                    $totalUploadedFiles++;
                } catch (FileSizeExceedsLimit $exception) {
                    $totalRejectedFiles++;
                    return;
                }
            });

        return response()->json([
            'message' => 'Files uploaded successfully',
            'total_uploaded' => $totalUploadedFiles,
            'total_rejected' => $totalRejectedFiles,
        ], JsonResponse::HTTP_OK);
    }
}
