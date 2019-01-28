<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Input;
use TijsVerkoyen\CssToInlineStyles\Css\Rule\Rule;

class EditCategoryRequest extends Request
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name'        => 'required|string|unique:category,name,'.$this->get("id").',id,restaurant_id,'.Input::get("restaurant").',branch_id,'.Input::get("branch").',deleted_at,NULL',
              'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Category Name is required!',
            'description.required' => 'Please fill out description!',
        ];
    }
}
