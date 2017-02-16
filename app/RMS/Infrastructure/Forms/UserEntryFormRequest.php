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
            'name'                => 'required|string',
            'staff_id'            => 'required|unique:users,staff_id,NULL,id,deleted_at,NULL',
            'login_password'      => 'required|min:8',
            'conpassword'         => 'required|same:login_password',
            'userType'            => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => 'User Name is required!',
            'staffId.required'      => 'Staff ID is required',
            'login_password.required'     => 'Password is required',
            'conpassword.required'  => 'Confirm Password is required',
            'conpassword.same'      => 'Password and Confirm Password must match',
            'userType.required'     => 'Staff Type is required'
        ];
    }
}
