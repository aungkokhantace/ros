<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;

class EditDiscountRequest extends Request
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'from_date'      => 'required|date|date_format:d-m-Y',
            'to_date'        => 'required|date|date_format:d-m-Y|after:from_date',
            'product' => 'required',
           'name' =>'required',
            'amount' => 'required|numeric'
        ];
    }
    public function messages()
    {
        return [
            'start_date.required' => 'Starting date must be later than end date!',
            'end_date.required' => 'End Date is wrong',
            'product.required' =>'Product is required',
            'name.required' => 'Discount Name is required',
            'amount.required' => 'Discount amount is required'
        ];
    }
}
