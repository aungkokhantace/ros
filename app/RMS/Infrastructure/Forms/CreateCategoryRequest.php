<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;

class CreateCategoryRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
          return [
                'name' => 'required|string|unique:category,name,NULL,id,deleted_at,NULL',
                'fileupload' => 'required|max:10240|image|mimes:jpeg,png,jpg',
                'description' => 'required',
            ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Category Name is required!',
            'name.unique' => 'This name is already taken!',
            'fileupload.required' => 'Please Choose Image. Image file size must not over 10MB',
            'description.required' => 'Please fill out description!',
        ];
    }

}



