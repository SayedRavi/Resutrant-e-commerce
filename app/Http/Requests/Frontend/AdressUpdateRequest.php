<?php

namespace App\Http\Requests\Frontend;

use App\Models\Adress;
use Illuminate\Foundation\Http\FormRequest;

class AdressUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $addressId = $this->route('id');
        $address = Adress::findOrFail($addressId);
        return  $address && $address->user_id == auth()->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'delivery_area_id' => 'required', 'string',
            'first_name' => 'required', 'string', 'max:20',
            'last_name' => 'nullable', 'string', 'max:20',
            'phone' => 'required', 'max:20',
            'email' => 'required', 'email', 'max:30',
            'address' => 'required',
            'type' => 'required', 'in:home,office'
        ];
    }
}
