<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Input;
class RoomEditRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // 'room_name'  => 'required|string',
            'room_name'     =>'required|unique:rooms,room_name,' . Input::get("id") . ',id,deleted_at,NULL',
            'capacity'      => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'room_name.required'    => 'Room Name is required!',
            'room_name.unique'      => 'This name is already taken.',
            'capacity.required'     => 'Capacity is required!',
            'capacity.integer'      => 'Capacity should be number only'
        ];
    }
}
