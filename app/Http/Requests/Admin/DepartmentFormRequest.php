<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $rules = [
            'name' => [
                'required',
                'string',
                'max:200'
            ],
            'image' => [
                'required',
                'image', 
                'mimes:jpeg,png,jpg,gif,svg', 
                'max:2048' 
            ],
            'icon' => [
                'required',
                'string',
                'max:100' 
            ],
            'description' => [
                'required',
                'string',
                'max:1000' 
            ],
        ];

        return $rules;
    }
}
