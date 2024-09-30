<?php

namespace App\Http\Requests\Superadmin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'firstname' => 'required',
            'lastname' => 'required',
            'username' => ['required', Rule::unique('admins')],
            'password' => 'required',
        ];
    }
}
