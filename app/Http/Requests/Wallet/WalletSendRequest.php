<?php

namespace App\Http\Requests\Wallet;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class WalletSendRequest extends FormRequest
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
            'receiver_phone' => ['required', 'string', 'max:20'],
            'amount' => ['nullable', 'numeric', 'min:0', 'max:99999999.99'],
        ];
    }
}
