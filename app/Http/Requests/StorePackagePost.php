<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePackagePost extends FormRequest
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
            'category-id'=>'required|exists:categories,id',
            'package-ru'=>'required|min:3',
            'price-rub'=>'required|numeric',
            'package-start'=>'required|date',
            'package-end'=>'required|date',
            'package-active'=>'nullable'
        ];
    }
}
