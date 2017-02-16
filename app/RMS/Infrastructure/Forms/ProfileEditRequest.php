<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;

class ProfileEditRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'login_password'      => 'required|min:8',
            'conpassword'         => 'required|same:login_password'
        ];
    }

    public function messages()
    {
        return [
            'login_password.required'     => 'Password is required',
            'conpassword.required'  => 'Confirm Password is required',
            'conpassword.same'      => 'Password and Confirm Password must match'
        ];
    }
}
