<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankValidator extends FormRequest
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
            'description' => 'required|unique:banks|max:255',
        ];
    }

       /**
     * Get the error messages that apply to the request parameters.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'description.required' => 'Descripion field is required',
            'description.unique' => 'Descripion exist',
        ];
    }
}
