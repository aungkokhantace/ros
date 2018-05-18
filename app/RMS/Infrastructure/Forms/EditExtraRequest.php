<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Input;
class EditExtraRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'price'         => 'required|numeric',
            'food_name'     =>'required|unique:add_on,food_name,' . Input::get("id") . ',id,category_id,' . Input::get("category_id") . ',deleted_at,NULL',
            'category_id'   => 'required',
            'description'   => 'required',
            'fileupload'    => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'price.numeric'         => 'Price must be numeric',
            'price.required'        => 'Price is required',
            'food_name.required'    => 'Food Name is required',
            'food_name.unique'      => 'This name is already taken.',
            'category_id.required'  => 'Category is required',
            'description.required'  => 'Description is required'
        ];
    }
}
