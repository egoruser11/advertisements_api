<?php

namespace App\Http\Requests\Assessment;

use Illuminate\Foundation\Http\FormRequest;

class ExaminateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id' => 'required|exists:advertisements,id',
            'status' => 'string|nullable',
            'reason' => 'required|numeric|between:1,5',
            'user_id' => 'required|numeric|between:1,5',
        ];
    }

}
