<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use FilesManager\File\Application\Find\FileFinder;
use FilesManager\File\Domain\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FileGetController extends Controller
{
    public function __construct(private readonly FileFinder $finder)
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
        $files = $this->finder->__invoke();

        $primitiveFiles = array_map(fn(File $file) => $file->toPrimitives(), $files);

        return response()->json([
            'data' => $primitiveFiles
        ], JsonResponse::HTTP_CREATED);
    }
}
