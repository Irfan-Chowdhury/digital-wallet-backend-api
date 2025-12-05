<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:255',
            'email'     => ['required','email', Rule::unique('users','email')->ignore($this->id)],
            // 'status'    => 'required|in:active,suspended,pending',
            'location'  => 'nullable|string|max:255',
            'bio'       => 'nullable|string',
            // 'interests' => 'nullable|array',
            // 'interests.*' => 'string|max:100',
            // 'countries' => 'nullable|array',
            // 'countries.*' => 'string|max:100',
            'image'     => 'nullable|image|max:2048',
        ];
    }
}
