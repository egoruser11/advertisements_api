<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class EndRegisterUserRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id' => 'required|integer|exists:users,id',
            'tax_number' => 'required|unique:users,tax_number',
            'legal_entity' => 'required',
            'legal_address' => 'required',
            'address_docs' => 'required',
        ];
    }

}
