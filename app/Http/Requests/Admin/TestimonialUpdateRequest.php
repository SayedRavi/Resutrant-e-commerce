<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialUpdateRequest extends FormRequest
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
            'name' => 'required| string',
            'title' => 'required| string',
            'review' => 'required| string | max:1000',
            'rating' => 'required| integer| max:5',
            'show_at_home' => 'required| boolean',
            'status' => 'required| boolean',
        ];
    }
}
