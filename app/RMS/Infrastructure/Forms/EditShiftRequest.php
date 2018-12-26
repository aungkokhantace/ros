<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Input;

class EditShiftRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
          return [
              'name'        => 'required|string|unique:shift,name,'.$this->get("id").',id,restaurant_id,'.Input::get("restaurant").',branch_id,'.Input::get("branch").',deleted_at,NULL',
              'description' => 'required',
            ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Shift Name is required!',
            
            'description.required' => 'Please fill out description!',
        ];
    }

}



