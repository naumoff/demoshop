<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentCardPatch extends FormRequest
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
        $paymentCardId = $this->request->all()['id'];
        return [
            'id'=>'required|exists:payment_cards,id',
            'bank'=>'required|min:3',
            'card-number'=>'required|numeric|digits:16|unique:payment_cards,card_number,'.$paymentCardId,
            'card-limit-eur'=>'required|numeric',
            'active'=>'nullable|numeric|size:1'
        ];
    }
}