<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDeliveryPatch extends FormRequest
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
    
    public function rules()
    {
        return [
            'min-weight'=>'required|numeric|min:1',
            'max-weight'=>'required|numeric',
            'delivery-cost'=>'required|numeric'
        ];
    }
    
    public function withValidator($validator)
    {
        $minValue = $this->request->all()['min-weight'];
        $maxValue = $this->request->all()['max-weight'];
        
        if($maxValue < $minValue){
            $validator->after(function ($validator) {
                $validator->errors()->add('field', 'Min weight has to be less then Max weight');
            });
        }
    }
}
