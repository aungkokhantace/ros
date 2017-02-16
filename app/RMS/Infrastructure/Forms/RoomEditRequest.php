<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;

class RoomEditRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'room_name'  => 'required|string',
            'capacity'   => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'room_name.required'    => 'Room Name is required!',
            'capacity.required'     => 'Capacity is required!',
            'capacity.integer'      => 'Capacity should be number only'
        ];
    }
}
