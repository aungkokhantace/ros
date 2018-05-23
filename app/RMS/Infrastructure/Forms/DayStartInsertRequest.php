<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;
use Carbon\Carbon;

class DayStartInsertRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function all()
    {
        $input          = parent::all();
        $input['start_date'] = Carbon::parse($input['start_date'])->format('Y-m-d');
        return $input;
    }

    public function rules()
    {
        return [
            'start_date'    => 'required|unique:order_day,start_date,NULL,id,deleted_at,NULL'
            ];
    }

    public function messages()
    {
        return [
            'start_date.required'   => 'Start Day Start is required',
            'start_date.unique'     => 'Start Day must be unique'
            
        ];
    }
}
