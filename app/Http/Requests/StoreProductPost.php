<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductPost extends FormRequest
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
            'group-id'=>'required|exists:groups,id',
            'product-ru'=>'required|min:3',
            'product-de'=>'required|min:3',
            'description'=>'required|min:15',
            'price-eur'=>'required|numeric',
            'price-rub_manual'=>'numeric|nullable',
            'price-with-discount'=>'nullable',
            'discount-start'=>'nullable',
            'discount-end'=>'nullable',
            'discount-active'=>'nullable|in:1,0',
            'weight-gr'=>'required|numeric',
            'active'=>'nullable|in:1,0'
        ];
    }
}
