<?php

namespace App\Http\Requests;

use FilesManager\File\Domain\File;

class FileBulkPostRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'files.*' => 'required|max:'.File::MAX_BYTES,
        ];
    }
}
