<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;

class LoginFormRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_name' => 'required',
            'password'=> 'required|min:8',
        ];
    }
    public function messages()
    {
        return [
            'user_name.required' => 'Please Type User Name!',
            'password.required' => 'Forgot to type password',
        ];
    }
}
