<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use FilesManager\File\Application\Delete\DeleteFileRequest;
use FilesManager\File\Application\Delete\FileDeleter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FileDeleteController extends Controller
{
    public function __construct(private readonly FileDeleter $deleter)
    {
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $this->deleter->__invoke(new DeleteFileRequest(
            $request->route('id'),
            $request->boolean('is_permanent')
        ));

        return response()->json([
            'message' => 'File deleted successfully'
        ], JsonResponse::HTTP_NO_CONTENT);
    }
}
