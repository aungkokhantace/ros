<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;

class TableEditRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "table_no"  => "required",
            "capacity"  => "required|integer",
        ];
    }

    public function messages(){
        return [
            "table_no.required"     => "Table name is required",
            "capacity.required"     => "Capacity is required",
            "capacity.integer"      => "Capacity should be number only"
        ];
    }
}
