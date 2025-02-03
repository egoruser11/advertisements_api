<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string',
            'surname' => 'required|string',
            'patronymic' => 'string|nullable',
            'phone' => 'required|string|regex:/^8\d{10}$/i',
            'post' => 'required|string',
            'tax_number' => 'string|unique:users,tax_number',
            'legal_entity' => 'string|nullable',
            'address_docs' => 'string|nullable',
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'email already exists',
        ];
    }

}
