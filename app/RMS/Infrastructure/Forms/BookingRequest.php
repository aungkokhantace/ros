<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;

class BookingRequest extends Request
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'date'              => 'required',
            'from_time'         => 'required',
            'quantity'          => 'required|numeric|max:12'
        ];
    }
    public function messages()
    {
        return [
            'date'          => 'Date is required',
            'from_time'     => 'From_time is required',
            'quantity'      => 'Number of people is required',
            'quantity.max'  => 'People are not greater than 12 people'
        ];
    }
}
