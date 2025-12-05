<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function FailedValidationTrait(Validator $validator)
    {
        if ($this->is('api/*') || $this->expectsJson()) {
            throw new HttpResponseException(
                response()->json(['errors' => $validator->errors()], 422)
            );
        }

        parent::FailedValidationTrait($validator);
    }


    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role' => ['sometimes', 'in:USER,AGENT'], // default customer হবে
            'phone' => ['required', 'string', 'min:8', 'unique:users,phone'],
            'address' => ['required', 'string', 'min:5'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
