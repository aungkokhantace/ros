<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;

class MemberTypeRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "type" => "required|unique:member_type",
            "description"=> "required",
            "discount_amount" => "required|numeric|max:100",
            "life_time" => "required|numeric",

        ];
    }
    public function messages()
    {
        return [
            'type.required' => 'Type is required',
            'description.required' => 'Description is required',
            'discount_amount.required' => 'Discount amount is required',
            'life_time.required' => 'Life time is required',
            'life_time.numeric' => 'Life time must be numeric'
        ];
    }


}
