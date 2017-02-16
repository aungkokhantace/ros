<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;

class MemberRegistrationFormRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'          =>'required',
            'phone'         =>'required|numeric',
            'birthday'      =>'required',
            'member_type'   =>'required',

        ];
    }

    public function messages()
    {
        return [
            'name.required'         => 'Member name is required',
            'phone.required'        => 'Phone is required',
            'birthday.required'     => 'Birthdate is required',
            'member_type.required'  =>'Member Type is required',
        ];
    }
}
