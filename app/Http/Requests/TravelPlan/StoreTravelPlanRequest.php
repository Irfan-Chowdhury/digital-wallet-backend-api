<?php

namespace App\Http\Requests\TravelPlan;

use Illuminate\Foundation\Http\FormRequest;

class StoreTravelPlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'     => ['required', 'exists:users,id'],
            'destination' => ['required', 'string', 'max:255'],
            'start_date'  => ['required', 'date'],
            'end_date'    => ['required', 'date', 'after_or_equal:start_date'],
            'budget'      => ['nullable', 'integer', 'min:0'],
            'travel_type' => ['nullable', 'string', 'max:50'],
            'itinerary'   => ['nullable', 'string'],
            'group_size'  => ['nullable', 'integer', 'min:1'],
            'status'      => ['required', 'in:active,completed,cancelled'],
        ];
    }
}
