<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentPartnerPatch extends FormRequest
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
        $partnerId = $this->request->all()['partner-id'];
        return [
            'sequence'=>'required|numeric|min:0',
            'first-name'=>'required|min:2',
            'last-name'=>'required|min:2',
            'email'=>'required|email|unique:payment_partners,email,'.$partnerId,
            'total-limit-eur'=>'required|numeric',
            'active'=>'nullable|in:0,1',
        ];
    }
}
