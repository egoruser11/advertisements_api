<?php

namespace App\Http\Requests\Advertisement;

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
            'offset' => 'integer|min:0',
            'limit' => 'integer|min:1|max:100',
            'rooms_count' => 'array',
            'rooms_count.*' => 'required|integer|distinct',
            'params_ids' => 'array',
            'params_ids.*' => 'required|integer|distinct',
            'max_cost' => 'integer|min:0',
            'min_cost' => 'integer|min:0',
            'city' => 'string',
            'guests_count' => 'integer|min:1',
            'arrival_date' => 'date_format:Y-m-d',
            'departure_date' => 'required_if:arrival_date|date_format:Y-m-d',
            'sort_field' => 'string|in:price,created_at,average_rating',
            'sort_dir' => 'string|in:asc,desc',
        ];
    }

}
