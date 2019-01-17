<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;

class UserEntryFormRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'                => 'required|unique:users,user_name,NULL,id,deleted_at,NULL',
            'login_password'      => 'required|numeric|min:8',
            'conpassword'         => 'required|same:login_password',
            'userType'            => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => 'User Name is required!',
            'name.unique'           =>'This name is already taken.',
            'name.numeric'          => 'Username must be numeric',
            'login_password.required' => 'Password is required',
            'login_password.numeric' => 'Password must be numeric',
            'conpassword.required'  => 'Confirm Password is required',
            'conpassword.same'      => 'Password and Confirm Password must match',
            'userType.required'     => 'Staff Type is required'
        ];
    }
}
