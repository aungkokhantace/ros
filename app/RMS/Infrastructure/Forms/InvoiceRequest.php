<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;

class InvoiceRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "payment"  => "required|integer",
        ];
    }

    public function messages(){
        return [
            "payment.required"     => "Payment is required",
            "payment.integer"      => "Payment should be number only"
        ];
    }
}
