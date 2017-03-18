<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberPostRequest extends FormRequest
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
            'name'=> 'required|max:100',
            'age' => 'required|max:3',
            'address'  => 'required|max:300',
            //'photo'   => 'image|mimes:png,jpg,jpeg,bmp|max:10000',
        ];
    }

    public function messages ()
    {
        return [
            'name.required'  => 'Please enter your name!',
            'name.max'    =>  'Name must be less than 100!',
            'age.required' =>  'Please enter your age',
            'age.max' =>  'Age must be less than 3!',
            'address.required'   => 'Please enter your address!',
            'address.max'   => 'Address must be less than 300',
            //'photo.image'      => 'This is images type!',
            //'photo.mimes'      => 'Please choose a valid image : png,jpg,jpeg,bmp',
            //'photo.max'      => 'Image must be less than 10M'
        ];
    }
}
