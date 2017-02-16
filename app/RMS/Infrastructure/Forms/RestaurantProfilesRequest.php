<?php

namespace App\RMS\Infrastructure\Forms;

use App\Http\Requests\Request;

class RestaurantProfilesRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
        'website'                    =>'url',
        'email'                      =>'email',
        'phone'                      =>'numeric',

     ];
    }

    public function messages()
    {
        return [
            'website.url'=>'Please enter a valid URL.',
            'email.email'=>'Please enter a valid email.',
            'phone.numeric'=>'Phone number must be numeric.',
        ];
    }
}
