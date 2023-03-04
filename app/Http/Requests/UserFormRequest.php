<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
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
     *
     */


    public function rules()
    {
        return [
            'over_name' => 'required|string|max:10',
            'under_name' => 'required|string|max:10',
            'over_name_kana' => 'required|string|max:30|regex:/\A[ァ-ヴー]+\z/u',
            'under_name_kana' => 'required|string|max:30|regex:/\A[ァ-ヴー]+\z/u',
            'mail_address' => 'required|string|email:filter|max:100|unique:users',
            'sex' => 'required',
            'birth_day' => 'required|before:today|after:1999-12-31',
            'role' => 'required',
            'password' => 'required|min:8|max:30|confirmed',
            'password_confirmation' => 'required',

        ];
    }

    protected function prepareForValidation()
    {
        $birth_day = $this->old_year .'-'. $this->old_month .'-'. $this->old_day ;

        $this->merge([
        'birth_day' => $birth_day
        ]);
    }

}
