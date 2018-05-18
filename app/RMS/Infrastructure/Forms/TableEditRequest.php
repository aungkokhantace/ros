<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Input;
class TableEditRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'table_no'     => 'required|unique:tables,table_no,' . Input::get("id") . ',id,deleted_at,NULL',
            "capacity"  => "required|integer",
        ];
    }

    public function messages(){
        return [
            "table_no.required"     => "Table name is required",
            'table_no.unique'       => "This name is already taken.",
            "capacity.required"     => "Capacity is required",
            "capacity.integer"      => "Capacity should be number only"
        ];
    }
}
