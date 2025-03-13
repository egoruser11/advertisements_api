<?php

namespace App\Http\Requests\Advertisement;

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
            'id' => 'required|integer|exists:advertisements,id',
            'city' => 'string',
            'beds_count' => 'integer',
            'rooms_count' => 'integer',
            'guests_count' => 'integer',
            'price' => 'numeric',
            'address' => 'string',
            'rules_cancellation' => 'string',
            'description' => 'string',
            'type_id' => 'integer|exists:types,id ',
            'params' => 'array',
            'params.*.id' => 'required|integer|exists:params,id',
            'params.*.value' => 'required|integer|between:0,1',
        ];
    }

}
