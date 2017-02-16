<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;

class MemberTypeEditRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "type" => "required",
            "description"=> "required",
            "discount_amount" => "required|numeric|max:100"
        ];
    }
    public function messages()
    {
        return [
            'type.required' => 'Type is required',
            'description.required' => 'Description is required',
            'discount_amount.required' => 'Discount amount is required'
        ];
    }
}
