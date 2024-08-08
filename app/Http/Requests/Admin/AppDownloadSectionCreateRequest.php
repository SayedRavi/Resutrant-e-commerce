<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AppDownloadSectionCreateRequest extends FormRequest
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
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'background' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required|string',
            'short_description' => 'required|string',
            'play_store_link' => 'nullable|string|url',
            'app_store_link' => 'nullable|string|url',
        ];
    }
}
