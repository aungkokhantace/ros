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
            "staff_id"  => "required|numeric",
        ];
    }

    public function messages()
    {
        return [
            "name.required"     => "Name is required",
            "staff_id.required" => "User ID is required",
            "staff_id.numeric"  => "User ID must be number"
        ];
    }
}
