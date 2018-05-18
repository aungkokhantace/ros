<?php

namespace App\RMS\Infrastructure\Forms;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\Request;

class ItemEditRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'=>'required|unique:items,name,' . Input::get("id") . ',id,category_id,' . Input::get("parent_category") . ',deleted_at,NULL',
            'parent_category'=>'required',
            'description'=>'required',
            'price'=>'required|numeric',

        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'Please Enter Item Name.',
            'name.unique'=>'This name is already taken.',
            'parent_category.required'=>'Please Choose Item Category.',
            'description.required'=>'Please Enter Item Description.',
            'price.required'=>'Please Enter Item Price.',
            'price.numeric'=>'Item Price must be a number.',
        ];
    }
}
