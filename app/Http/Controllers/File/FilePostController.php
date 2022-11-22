<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use FilesManager\File\Application\Create\CreateFileRequest;
use FilesManager\File\Application\Create\FileCreator;
use FilesManager\Shared\Domain\UploadFile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FilePostController extends Controller
{
    public function __construct(private readonly FileCreator $creator)
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
        $file = $this->creator->__invoke(new CreateFileRequest(
            UploadFile::fromFile($request->file('file'))
        ));

        return response()->json([
            'message' => 'File uploaded successfully',
            'file' => $file->toPrimitives()
        ], JsonResponse::HTTP_CREATED);
    }
}
