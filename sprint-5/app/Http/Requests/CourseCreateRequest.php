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
            'videos' => 'required|array|min:1',
            'videos.*.title' => 'required|string|min:5|max:50',
            'videos.*.description' => 'required|string|min:5|max:255',
            'videos.*.url' => 'required|url'
        ];
    }
}
