<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Category;

class EditGroupPatch extends FormRequest
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
            'group-id'=>'required|exists:groups,id',
            'group-name'=>'required|min:3|'
        ];
    }
    
    public function withValidator($validator)
    {
        $validator->after(function($validator){
            $categoryId = $this->request->all()['category-id'];
            $newGroupName = $this->request->all()['group-name'];
            $duplicateGroup = Category::find($categoryId)
                ->groups()
                ->where('group','=',$newGroupName)
                ->first();
            if($duplicateGroup !== null){
                $validator->errors()->add('group-name',"Группа с именем {$newGroupName} уже существует");
            }
        });
    }
}
