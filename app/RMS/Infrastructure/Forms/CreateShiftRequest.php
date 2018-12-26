<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Input;
use TijsVerkoyen\CssToInlineStyles\Css\Rule\Rule;
class CreateShiftRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
          return [
              'name'        => 'required|string|unique:shift,name,NULL,id,restaurant_id,'.Input::get("restaurant").',branch_id,'.Input::get("branch").',deleted_at,NULL',
              'description' => 'required',

            ];
    }
    public function messages()
    {
        return [
            'name.required'        => 'Shift Name is required!',
            'name.unique'          => 'This name is already taken!',
            'description.required' => 'Please fill out description!',
        ];
    }

}



