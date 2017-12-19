<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderReceptorPatch extends FormRequest
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
            'order_id'=>'required|exists:orders,id',
            'user_first_name'=>'required|min:2',
            'user_last_name'=>'required|min:2',
            'user_phone'=>'required|min:7',
            'user_country'=>'required|min:2',
            'user_post_index'=>'required|min:2',
            'user_city'=>'required|min:2',
            'user_street'=>'required|min:2',
            'user_building_number'=>'required|min:1',
            'user_apartment_number'=>'required|min:1'
        ];
    }

}
