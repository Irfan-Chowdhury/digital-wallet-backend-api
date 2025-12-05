<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            // 'status'    => 'required|in:active,suspended,pending',
            'location'  => 'nullable|string|max:255',
            'bio'       => 'nullable|string',
            //'interests' => 'nullable|array',
            //'interests.*' => 'string|max:100',
            //'countries' => 'nullable|array',
            //'countries.*' => 'string|max:100',
            // 'image'     => 'nullable|image|max:2048',
            'image' => 'nullable|file|image|max:2048', // add image validation
        ];
    }
}
