<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;

class ContinentEditRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'continent_name'       => 'required|string',
           
        ];
    }
    public function messages(){
        return [
            'continent_name'       => 'Continent Name is required.',
           
        ];
    }
}
