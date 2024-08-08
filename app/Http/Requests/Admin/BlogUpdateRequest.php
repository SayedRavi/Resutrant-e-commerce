<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BlogUpdateRequest extends FormRequest
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
        $id = $this->blog;
        return [

                'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'title' => 'required|string|max:255| unique:blogs,title,'.$id,
                'category_id' => 'required',
                'description' => 'required|string',
                'seo_title' => 'sometimes| max:255',
                'seo_description' => 'sometimes',
                'show_at_home' => 'required|boolean',
                'status' => 'required|boolean',

        ];
    }
}
