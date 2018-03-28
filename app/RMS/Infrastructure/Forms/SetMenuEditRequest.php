<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;

class SetMenuEditRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {   

        return [
            'set_menus_name'    => 'required',
            'item'              => 'required',
            'set_menus_price'   => 'required|numeric',
            'status'            => 'required',
            'fileupload'        => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'set_menus_name.required'   => 'Set Menu Name is required',
            'item.required'             => 'Items are required',
            'set_menus_price.numeric'   => 'Price must be numeric',
            'set_menus_price.required'  => 'Price field is required'
        ];
    }
}