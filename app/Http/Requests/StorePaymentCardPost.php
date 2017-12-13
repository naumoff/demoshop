<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentCardPost extends FormRequest
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
            'holder-id'=>'required|exists:payment_partners,id',
            'bank'=>'required|min:3',
            'card-number'=>'required|numeric|unique:payment_cards,card_number',
            'card-limit-eur'=>'required',
            'active'=>'nullable|in:1,0'
        ];
    }
}
