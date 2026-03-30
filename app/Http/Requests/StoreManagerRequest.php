<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreManagerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[A-Za-z\s\.\'-]+$/',
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => 'Name may only contain letters, spaces, apostrophes, hyphens, and dots.',
        ];
    }
}
