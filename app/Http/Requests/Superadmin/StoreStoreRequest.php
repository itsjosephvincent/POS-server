<?php

namespace App\Http\Requests\Superadmin;

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
            'admin_uuid' => 'required',
            'store_name' => 'required',
            'branch' => 'required',
            'username' => ['required', Rule::unique('stores')],
            'password' => 'required',
        ];
    }
}
