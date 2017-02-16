<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;

class ItemEntryRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'=>'required|unique:items,name,NULL,id,deleted_at,NULL',
            'parent_category'=>'required',
            'description'=>'required',
            'price'=>'required|numeric',
            'fileupload'=>'required|max:10240'
           
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
            'fileupload.required'=>'Please Choose Image. Image file size must not over 10MB'

        ];
    }
}
