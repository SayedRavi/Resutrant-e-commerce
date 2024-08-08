<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ChefCreateRequest extends FormRequest
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string|min:3|max:50',
            'title' => 'required|string|min:3|max:50',
            'fb' => 'nullable|string',
            'linked' => 'nullable|string',
            'x' => 'nullable|string',
            'web' => 'nullable|string',
            'show_at_home' => 'required|boolean',
            'status' => 'required|string|boolean',

        ];
    }
}
