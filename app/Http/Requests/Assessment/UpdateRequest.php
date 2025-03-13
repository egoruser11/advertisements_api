<?php

namespace App\Http\Requests\Assessment;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id' => 'required|exists:assessments,id',
            'review' => 'string',
            'price_quality' => 'numeric|between:1,5',
            'timeliness_of_the_meeting' => 'numeric|between:1,5',
            'purity' => 'numeric|between:1,5',
            'photo_match' => 'numeric|between:1,5',
            'convenience_of_location' => 'numeric|between:1,5',
            'is_anonymous' => 'boolean',
        ];
    }

}
