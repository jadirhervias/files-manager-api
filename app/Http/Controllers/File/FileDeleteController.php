<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use FilesManager\File\Application\Delete\DeleteFileRequest;
use FilesManager\File\Application\Delete\FileDeleter;
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
     * @return void
     */
    public function __invoke(Request $request): void
    {
        $this->deleter->__invoke(new DeleteFileRequest(
            $request->route('id'),
            $request->boolean('is_permanent')
        ));
    }
}
