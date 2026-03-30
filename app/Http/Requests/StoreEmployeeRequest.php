<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            'employee_id' => [
                'required',
                'string',
                'max:255',
                'regex:/^[A-Za-z0-9\s_-]+$/',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[\W_]/',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => 'Name may only contain letters, spaces, apostrophes, hyphens, and dots.',
            'employee_id.regex' => 'Employee ID may only contain letters, numbers, dashes, and underscores.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.regex' => 'Password must include uppercase, lowercase, number, and special character.',
        ];
    }
}
