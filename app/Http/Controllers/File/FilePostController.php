<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use FilesManager\File\Application\Create\CreateFileRequest;
use FilesManager\File\Application\Create\FileCreator;
use FilesManager\Shared\Domain\UploadFile;
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
     * @return array
     */
    public function __invoke(Request $request): array
    {
        $file = $this->creator->__invoke(new CreateFileRequest(
            UploadFile::fromFile($request->file('file'))
        ));

        return $file->toPrimitives();
    }
}
