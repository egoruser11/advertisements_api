<?php

namespace App\Http\Requests\Reservation;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'limit' => 'integer|required',
            'offset' => 'integer|required',
            'city' => 'string|nullable',
            'arrival_date_min' => 'string|nullable',
            'arrival_date_max' => 'string|nullable',
            'departure_date_min' => 'string|nullable',
            'departure_date_max' => 'string|nullable',
            'status' => 'string|nullable',
        ];
    }

}
