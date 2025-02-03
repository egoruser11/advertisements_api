<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'tax_number' => 'unique:users,tax_number',
            'legal_entity' => 'string',
            'legal_address' => 'string',
            'address_docs' => 'string',
        ];
    }

}
