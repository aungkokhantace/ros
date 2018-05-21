<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Input;

class ItemEntryRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'=>'required|unique:items,name,NULL,id,category_id,' . Input::get("parent_category") . ',deleted_at,NULL',
            'parent_category'=>'required',
            'description'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'Please Enter Item Name.',
            'name.unique'=>'This name is already taken.',
            'parent_category.required'=>'Please Choose Item Category.',
            'description.required'=>'Please Enter Item Description.'
        ];
    }
}
