<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ContactUpateRequest extends FormRequest
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
            'phone_one' => 'sometimes|regex:/^([0-9\s\-\+\(\)]*)$/',
            'phone_two' => 'sometimes|regex:/^([0-9\s\-\+\(\)]*)$/',
            'email_one' => 'sometimes|email',
            'email_two' => 'sometimes|email',
            'address' => 'sometimes',
            'map_link' => 'sometimes',
        ];
    }
}
