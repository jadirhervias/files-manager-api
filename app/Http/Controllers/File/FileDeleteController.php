<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileDeleteRequest;
use FilesManager\File\Application\Delete\DeleteFileRequest;
use FilesManager\File\Application\Delete\FileDeleter;
use FilesManager\File\Domain\FileNotExists;
use Illuminate\Http\JsonResponse;

class FileDeleteController extends Controller
{
    public function __construct(private readonly FileDeleter $deleter)
    {
    }

    /**
     * Handle the incoming request.
     *
     * @param FileDeleteRequest $request
     * @return JsonResponse
     */
    public function __invoke(FileDeleteRequest $request): JsonResponse
    {
        try {
            $this->deleter->__invoke(new DeleteFileRequest(
                $request->route('id'),
                $request->boolean('is_permanent')
            ));

            return response()->json([
                'message' => 'File deleted successfully'
            ], JsonResponse::HTTP_OK);
        } catch (FileNotExists $exception) {
            return response()->json(
                $exception->toArray(),
                JsonResponse::HTTP_NOT_FOUND
            );
        }
    }
}
