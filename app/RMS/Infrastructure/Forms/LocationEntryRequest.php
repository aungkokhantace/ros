<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;

class LocationEntryRequest extends Request
{
    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'location_type'=>'required|unique:locations,location_type,NULL,id,deleted_at,NULL',
        ];
    }

    public function messages()
    {
        return [
            'location_type.required'=>'Please Enter Location Name.',
            'location_type.unique'=>'This Location Name already exists.',
        ];
    }
}
