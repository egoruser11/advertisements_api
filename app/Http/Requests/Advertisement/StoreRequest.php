<?php

namespace App\Http\Requests\Advertisement;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'city' => 'string',
            'beds_count' => 'integer',
            'rooms_count' => 'integer',
            'guests_count' => 'integer',
            'price' => 'required|numeric',
            'address' => 'required|string',
            'rules_cancellation' => 'string',
            'description' => 'string',
            'type_id' => 'required|integer|exists:types,id ',
            'params' => 'array',
        ];
    }

}
