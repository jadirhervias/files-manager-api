<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Jobs\UploadFile;
use Illuminate\Http\Request;

class FileBulkPostController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return void
     * @throws \Throwable
     */
    public function __invoke(Request $request): void
    {
        $uploads = $request->allFiles();

        foreach ($uploads as $upload) {
            UploadFile::dispatch($upload);
        }
    }
}
