<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseCreateRequest extends FormRequest
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
            'title' => 'required|string|min:5|max:50',
            'description' => 'required|string|min:5|max:255',
            'content' => 'required|array',
            'content.*.title' => 'required|string|min:5|max:50',
            'content.*.description' => 'required|string|min:5|max:255',
            'content.*.videos' => ['bail', 'present', 'array', 'min:1'],
            'content.*.videos.*.title' => ['required', 'string', 'min:5', 'max:50'],
            'content.*.videos.*.description' => ['required', 'string', 'min:5', 'max:255'],
            'content.*.videos.*.url' => ['required', 'url'],

        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title field must be a string.',
            'title.min' => 'The title field must be at least 5 characters.',
            'title.max' => 'The title field must not be greater than 50 characters.',
            'description.required' => 'The description field is required.',
            'description.string' => 'The description field must be a string.',
            'description.min' => 'The description field must be at least 5 characters.',
            'description.max' => 'The description field must not be greater than 255 characters.',
            'content.required' => 'The content field is required.',
            'content.array' => 'The content field must be an array.',
            'content.*.title.required' => 'The content title field is required.',
            'content.*.title.string' => 'The content title field must be a string.',
            'content.*.title.min' => 'The content title field must be at least 5 characters.',
            'content.*.title.max' => 'The content title field must not be greater than 50 characters.',
            'content.*.description.required' => 'The content description field is required.',
            'content.*.description.string' => 'The content description field must be a string.',
            'content.*.description.min' => 'The content description field must be at least 5 characters.',
            'content.*.description.max' => 'The content description field must not be greater than 255 characters.',
            'content.*.videos.required' => 'The videos field is required.',
            'content.*.videos.array' => 'The videos field must be an array.',
            'content.*.videos.min' => 'The videos field must have at least 1 item.',
            'content.*.videos.*.title.required' => 'The Video title field is required.',
            'content.*.videos.*.title.string' => 'The Video title field must be a string.',
            'content.*.videos.*.title.min' => 'The Video title field must be at least 5 characters.',
            'content.*.videos.*.title.max' => 'The Video title field must not be greater than 50 characters.',
            'content.*.videos.*.description.required' => 'The Video description field is required.',
            'content.*.videos.*.description.string' => 'The Video description field must be a string.',
            'content.*.videos.*.description.min' => 'The Video description field must be at least 5 characters.',
            'content.*.videos.*.description.max' => 'The Video description field must not be greater than 255 characters.',
            'content.*.videos.*.url.required' => 'The Video url field is required.',
            'content.*.videos.*.url.url' => 'The Video url format is invalid.',
        ];
    }
}
