<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;

class RoomEntryRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'room_name'     => "required|string|unique:rooms,room_name,NULL,id,deleted_at,NULL",
            'capacity'      => 'required|integer',
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
