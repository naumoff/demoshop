<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePartnerPost extends FormRequest
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
            'sequence'=>'required|min:0|numeric',
            'first-name'=>'required|min:2',
            'last-name'=>'required|min:2',
            'email'=>'required|email|unique:payment_partners,email',
            'total-limit-eur'=>'required|numeric',
            'active'=>'nullable'
        ];
    }
}
