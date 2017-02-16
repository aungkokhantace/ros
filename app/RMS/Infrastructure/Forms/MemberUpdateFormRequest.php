<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;

class MemberUpdateFormRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'=>'required',
            'phone'=>'required|numeric',
            'email'=>'required',
            'birthday'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Member name is required',
            'phone.required' => 'Phone is required',
            'email.required' => 'Email is required',
            'birthday.required'=> 'Birthdate is required'
        ];
    }
}
