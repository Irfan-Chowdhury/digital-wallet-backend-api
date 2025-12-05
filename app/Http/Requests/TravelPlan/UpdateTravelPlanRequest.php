<?php

namespace App\Http\Requests\TravelPlan;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTravelPlanRequest extends FormRequest
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
            'destination' => ['sometimes', 'string', 'max:255'],
            'start_date'  => ['sometimes', 'date'],
            'end_date'    => ['sometimes', 'date', 'after_or_equal:start_date'],
            'budget'      => ['sometimes', 'nullable', 'integer', 'min:0'],
            'travel_type' => ['sometimes', 'nullable', 'string', 'max:50'],
            'itinerary'   => ['sometimes', 'nullable', 'string'],
            'group_size'  => ['sometimes', 'integer', 'min:1'],
            'status'      => ['sometimes', 'in:active,completed,cancelled'],
        ];
    }
}
