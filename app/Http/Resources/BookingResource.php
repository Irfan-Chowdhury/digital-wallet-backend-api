<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user' => $this->user->name,
            'service' => $this->service->name,
            'booking_date' => $this->booking_date,
            'status' => $this->status,
            'created_at'  => $this->created_at->toDateTimeString(),
        ];
    }

}
