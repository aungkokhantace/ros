<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;

class StaffTypeRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "name" =>"required",
            "description" => "required",
            "permission" => "required"
        ];
    }

    public function messages(){
        return [
            "name.required" => "Staff Type Name is required",
            "description.required" => "Description is required",
            "permission.required" => "Permission is required"
        ];
    }
}
