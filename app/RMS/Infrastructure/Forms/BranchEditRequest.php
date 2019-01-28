<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Input;


class BranchEditRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return [
              'name'        => 'required|string|unique:branch,name,'.$this->get("id").',id,restaurant_id,'.Input::get("restaurant").',deleted_at,NULL',
              'description' => 'required',
            ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
       return [
            'name.required' => 'Branch Name is required!',
            
            'description.required' => 'Please fill out description!',
        ];
    }
}
