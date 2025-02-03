<?php

namespace App\Http\Requests\Advertisement;

use Illuminate\Foundation\Http\FormRequest;

class AddAssessmentRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'advertisement_id' => 'required|exists:advertisements,id',
            'review' => 'string|nullable',
            'price_quality' => 'required|numeric|between:1,5',
            'timeliness_of_the_meeting' => 'required|numeric|between:1,5',
            'purity' => 'required|numeric|between:1,5',
            'photo_match' => 'required|numeric|between:1,5',
            'convenience_of_location' => 'required|numeric|between:1,5',
            'is_anonymous' => 'boolean',
        ];
    }

}
