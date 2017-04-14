<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProduct extends FormRequest
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
        $product = $this->route('product');

        return [
            'lm' => 'required|integer|digits_between:4,10|unique:products,lm,'.$product->id,
            'name' => 'required|string|min:2|max:100',
            'category' => 'required|string|min:2|max:20',
            'price' => 'required|numeric|min:0.1',
            'free_shipping' => 'required|integer|min:0|max:1',
        ];
    }
}
