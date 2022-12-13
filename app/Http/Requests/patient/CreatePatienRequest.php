<?php

namespace App\Http\Requests\patient;

use Illuminate\Foundation\Http\FormRequest;

class CreatePatienRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email|unique:patients,email,'.$this->get('id'),
            'contact_no' => 'required|numeric|digits:10',
            'category' => 'required|not_in:0'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':Attribute is required',
        ];
    }

    public function attributes()
    {
        return [

            'name' => 'name',
            'email.required' => 'email',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'The email ID you entered already exist',
            'contact_no' => 'Contact No',
            'category' => 'Category',

        ];
    }
}
