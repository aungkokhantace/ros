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
            'staff_id' => 'required',
            'password'=> 'required|min:8',
        ];
    }
    public function messages()
    {
        return [
            'staff_id.required' => 'Please Type User ID!',
            'password.required' => 'Forgot to type password',
        ];
    }
}
