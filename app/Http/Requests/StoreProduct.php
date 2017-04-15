<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduct extends FormRequest
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
        $max_file = 5 * 1024; // in kb
        $mimes = 'xlsx';
        $mimetypes = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';

        return [
            'file' => 'required'
//                .'|mimes:'.$mimes
//                .'|mimetypes:'.$mimetypes
                .'|max:'.$max_file,
        ];
    }
}
