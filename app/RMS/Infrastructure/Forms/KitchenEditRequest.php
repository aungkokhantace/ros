<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;

class KitchenEditRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'Please Enter Kitchen Name.'
        ];
    }
}
