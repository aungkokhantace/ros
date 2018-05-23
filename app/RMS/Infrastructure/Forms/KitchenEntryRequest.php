<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;

class KitchenEntryRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'=>'required|unique:kitchen,name,NULL,id,deleted_at,NULL',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'Please Enter Kitchen Name.',
            'name.unique'=>'This Kitchen Name already exists.',
        ];
    }
}
