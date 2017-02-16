<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;

class EditCategoryRequest extends Request
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name' => 'required|string',
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'User Name is required!',
            'description.required' => 'Please fill out description!',
        ];
    }
}
