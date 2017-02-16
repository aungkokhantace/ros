<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;

class LocationEditRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'location_type'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'location_type.required'=>'Please Enter Location Name.'
        ];
    }
}
