<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;

class CreateShiftRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
          return [
                'name' => 'required|string|unique:shift,name,NULL,id,deleted_at,NULL',
                'description' => 'required',
            ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Shift Name is required!',
            'name.unique' => 'This name is already taken!',
            'description.required' => 'Please fill out description!',
        ];
    }

}



