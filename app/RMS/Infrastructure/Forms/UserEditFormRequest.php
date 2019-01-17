<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;

class UserEditFormRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "name"      => "required",
        ];
    }

    public function messages()
    {
        return [
            "name.required"     => "Name is required",
            "name.numeric"      => "Username must be numeric",
        ];
    }
}
