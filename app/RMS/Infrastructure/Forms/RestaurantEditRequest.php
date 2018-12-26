<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;

class RestaurantEditRequest extends Request
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
       // dd("rule");
        return [
            // 'name'=>'required|unique:restaurant,name,NULL,id,deleted_at,NULL',
            'name'      => 'required',
            'email'     => "email|unique:restaurant",
            'website'   => 'url',
            // 'phone'     => 'required',
            // 'address'   => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'Name is required.',
            // 'name.unique'   => 'Name is already exists.',
            // 'email.required'=>'Email is required.',
            'email.unique'  => 'Email is already exists.',
            // 'website.required'=>'URL is required.',
            // 'address.required' =>'Address is required',


            
        ];
    }
}