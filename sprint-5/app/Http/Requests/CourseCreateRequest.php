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
            'videos' => ['bail', 'present', 'array', 'min:1'],
            'videos.*.title' => ['required', 'string', 'min:5', 'max:50'],
            'videos.*.description' => ['required', 'string', 'min:5', 'max:255'],
            'videos.*.url' => ['required', 'url'],

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
            'videos.required' => 'The videos field is required.',
            'videos.array' => 'The videos field must be an array.',
            'videos.min' => 'The videos field must have at least 1 item.',
            'videos.*.title.required' => 'The Video title field is required.',
            'videos.*.title.string' => 'The Video title field must be a string.',
            'videos.*.title.min' => 'The Video title field must be at least 5 characters.',
            'videos.*.title.max' => 'The Video title field must not be greater than 50 characters.',
            'videos.*.description.required' => 'The Video description field is required.',
            'videos.*.description.string' => 'The Video description field must be a string.',
            'videos.*.description.min' => 'The Video description field must be at least 5 characters.',
            'videos.*.description.max' => 'The VIdeo description field must not be greater than 255 characters.',
            'videos.*.url.required' => 'The Video url field is required.',
            'videos.*.url.url' => 'The Video url format is invalid.',
        ];
    }
}
