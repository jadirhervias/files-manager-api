<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileBulkPostRequest;
use FilesManager\File\Application\BulkMany\BulkFilesRequest;
use FilesManager\File\Application\BulkMany\FilesBulkCreator;
use FilesManager\Shared\Domain\UploadFile;
use Illuminate\Http\JsonResponse;

class FileBulkPostController extends Controller
{
    public function __construct(private readonly FilesBulkCreator $bulkCreator)
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
        $httpUploads = $request->allFiles()['files'];
        $uploads = [];

        collect($httpUploads)
            ->chunkWhile(function (\Illuminate\Http\UploadedFile $upload) use (&$uploads) {
                $uploads[] = UploadFile::fromFile($upload);
            });

        $bulkResponse = $this->bulkCreator->__invoke(new BulkFilesRequest($uploads));

        return response()->json([
            'message' => 'Files uploaded successfully',
            'data' => [
                'total_uploaded' => $bulkResponse->totalUploaded(),
                'total_rejected' => $bulkResponse->totalRejected(),
            ]
        ], JsonResponse::HTTP_OK);
    }
}
