<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
            'username' => 'required|string|min:2|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|regex:/[!@#$%^&*()\-_=+{};:,<.>]/|confirmed',
        ];
    }

    public function messages()
{
    return [
        'username.required' => 'The username field is required.',
        'username.min' => 'The username must be at least 2 characters.',
        'username.max' => 'The username must not be greater than 20 characters.',

        'email.required' => 'The email field is required.',
        'email.email' => 'The email must be a valid email address.',
        'email.unique' => 'The email has already been taken.',

        'password.required' => 'The password field is required.',
        'password.min' => 'The password must be at least 8 characters.',
        'password.regex' => 'The password must contain at least one special character.',
        'password.confirmed' => 'The password confirmation does not match.',
    ];
}



}
