<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;

class RemarkEditRequest extends Request
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
            'remark_name'       => 'required|string',
           
        ];
    }
    public function messages(){
        return [
            'remark_name'       => 'Name is required.',
           
        ];
    }
}
