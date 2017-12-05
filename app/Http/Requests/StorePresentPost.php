<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePresentPost extends FormRequest
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
            'present-ru'=>'required|min:3',
            'present-de'=>'required|min:3',
            'description'=>'required|min:15',
            'urls.*'=>'required|file|image|max:100',
            'weight-gr'=>'required|numeric',
            'min-order-value-rub'=>'required|numeric',
            'max-order-value-rub'=>'required|numeric',
            'active'=>'nullable',
        ];
    }
    
    public function messages()
    {
        return [
            'urls.*.required' => 'Требуeтся обязательная загрузка фотографии.',
            'urls.*.image'  => 'Загружаемый файл должен быть картинкой.',
            'urls.*.max'  => 'Загружаемая картинка должна иметь максимальный размер 5 МБ.',
        ];
    }
}
