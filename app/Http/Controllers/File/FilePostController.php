<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilePostRequest;
use FilesManager\File\Application\Create\CreateFileRequest;
use FilesManager\File\Application\Create\FileCreator;
use FilesManager\File\Domain\FileSizeExceedsLimit;
use FilesManager\Shared\Domain\UploadFile;
use Illuminate\Http\JsonResponse;

class FilePostController extends Controller
{
    public function __construct(private readonly FileCreator $creator)
    {
    }

    /**
     * Handle the incoming request.
     *
     * @param FilePostRequest $request
     * @return JsonResponse
     */
    public function __invoke(FilePostRequest $request): JsonResponse
    {
        try {
            $file = $this->creator->__invoke(new CreateFileRequest(
                UploadFile::fromFile($request->file('file'))
            ));

            return response()->json([
                'message' => 'File uploaded successfully',
                'file' => $file->toPrimitives()
            ], JsonResponse::HTTP_CREATED);
        } catch (FileSizeExceedsLimit $exception) {
            return response()->json(
                $exception->toArray(),
                JsonResponse::HTTP_BAD_REQUEST
            );
        }
    }
}
