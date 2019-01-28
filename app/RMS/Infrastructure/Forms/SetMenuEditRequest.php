<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Input;


class SetMenuEditRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {   

        return [
            'set_menus_name'    => 'required:set_menu,name,'.$this->get("id").',id,branch_id,'.Input::get("branch").',deleted_at,NULL',
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