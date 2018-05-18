<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Input;
class LocationEditRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // 'location_type'=>'required',
            'location_type'     => 'required|unique:locations,location_type,' . Input::get("id") . ',id,deleted_at,NULL',
        ];
    }

    public function messages()
    {
        return [
            'location_type.required'    => 'Please Enter Location Name.',
            'location_type.unique'      => 'This name is already taken.',
        ];
    }
}
