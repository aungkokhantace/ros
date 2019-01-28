<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Input;

class KitchenEditRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'=>'required:kitchen,name,'.$this->get("id").',id,branch_id,'.Input::get("branch").',deleted_at,NULL',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'Please Enter Kitchen Name.',
            
        ];
    }
}
