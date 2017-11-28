<?php

namespace App\Http\Requests;

use App\Category;
use Illuminate\Foundation\Http\FormRequest;

class StoreGroupPost extends FormRequest
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
            'new-group'=>'required|min:3'
        ];
    }
    
    public function withValidator($validator)
    {
        $validator->after(function($validator){
            $categoryId = $this->request->all()['category-id'];
            $newGroupName = $this->request->all()['new-group'];
            $duplicateGroup = Category::find($categoryId)
                ->groups()
                ->where('group','=',$newGroupName)
                ->first();
            if($duplicateGroup !== null){
                $validator->errors()->add('new-group',"Группа с именем {$newGroupName} уже существует");
            }
        });
    }
}
