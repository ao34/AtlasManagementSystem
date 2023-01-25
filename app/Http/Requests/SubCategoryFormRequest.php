<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryFormRequest extends FormRequest
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
            'main_category_id' => 'required|exists:main_categories',
            'sub_category' => 'required|max:100|string|unique:sub_categories',
            //
        ];
    }

    public function messages(){
        return [
            'sub_category.max' => '100文字以内で入力してください。',
            'sub_category.unique' => '既に登録されています。',
        ];
    }
}
