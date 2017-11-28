<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditCategoryPatch extends FormRequest
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
    $categoryId = $this->request->all()['id']; // доступ к полю формы с именем id
    return [
        'id'=>'required|min:1|exists:categories,id',
        'category-name'=> 'required|min:3|unique:categories,category,'.$categoryId
    ];
}
}
