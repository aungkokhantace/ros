<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;

class GeneralConfigRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tax'               =>'numeric|max:100|min:0',
            'service'           =>'numeric|max:100|min:0',
            'room_charge'       =>'numeric',
        ];
    }

    public function messages()
    {
        return [
            'tax.max'=>'Tax must be under 100%.',
            'tax.min'=>'Tax must be above 0%.',
            'tax.numeric'=>'Tax must be numeric.',
            'service.max'=>'Service charge must be under 100%.',
            'service.min'=>'Service charge must be above 0%.',
            'service.numeric'=>'Service charge must be numeric.',
            'room_charge.numeric'=>'Room charge must be numeric.',
        ];
    }
}
