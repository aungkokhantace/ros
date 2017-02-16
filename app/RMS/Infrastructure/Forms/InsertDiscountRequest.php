<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;

class InsertDiscountRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'from_date'      => 'required|date|before:to_date',
            'to_date'        => 'required|date|after:from_date',
            'product'        => 'required',
            'name'           =>'required',
            'amount'         => 'required|numeric'
        ];
    }
    public function messages()
    {
        return [
            'from_date.required'    => 'Start date is required.',
            'from_date.before'      => 'Start date must be before end date.',
            'to_date.required'      => 'End date is required',
            'to_date.after'         => 'End date must be after start date.',
            'product.required'      =>'Product is required.',
            'name.required'         => 'Discount name is required',
            'amount.required'       => 'Discount amount is required'

        ];
    }
}
