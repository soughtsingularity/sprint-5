<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|',
            'password' => 'required|min:8|regex:/[!@#$%^&*()\-_=+{};:,<.>]/',
        ];
    }

    public function messages()
    {
        return [
    
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
    
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.regex' => 'The password must contain at least one special character.',
        ];
    }
}
