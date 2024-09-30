<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'store_name' => 'required',
            'branch' => 'required',
            'username' => ['required', Rule::unique('stores')],
            'password' => 'required',
        ];
    }
}
