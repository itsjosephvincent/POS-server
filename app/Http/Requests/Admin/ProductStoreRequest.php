<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'category_uuid' => ['required', 'uuid'],
            'name' => 'required',
            'image' => ['sometimes', 'max:10240'],
            'cost' => ['required', 'regex:/^\d{1,6}(\.\d{1,2})?$/'],
            'price' => ['required', 'regex:/^\d{1,6}(\.\d{1,2})?$/'],
            'inventory' => ['required', 'integer'],
        ];
    }
}
