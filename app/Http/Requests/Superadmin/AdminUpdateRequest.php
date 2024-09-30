<?php

namespace App\Http\Requests\Superadmin;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user_uuid = $this->route()->parameters();
        $admin = Admin::where('uuid', $user_uuid)->first();

        return [
            'firstname' => 'required',
            'lastname' => 'required',
            'username' => ['required', Rule::unique('admins')->ignore($admin->id)],
        ];
    }
}
