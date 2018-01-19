<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Input;

class InvoiceRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = $this->rules;
        $payment_rule       = Input::get('payment');
        $total_rule         = Input::get('all_total');
        $foc_rule           = Input::get('foc');
        $payment_foc_rule   = $payment_rule + $foc_rule;

        if ($payment_rule !== '' AND $total_rule > $payment_foc_rule)
        {
            $rules['payment_check'] = 'required';
        } else {
            $rules['payment'] = 'required|integer';
        }
        return $rules;
    }

    public function messages(){
        return [
            "payment.required"           => "Payment is required",
            "payment_check.required"     => "Payment Amount is less than Net Amount",
            "payment.integer"            => "Payment should be number only"
        ];
    }
}
