<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'secret_code' => 'required|string|size:' . User::SECRET_CODE_LENGTH,
            'password' => 'required|string|min:10',
            'repeated_password' => 'required|string|same:password',
        ];
    }

}
