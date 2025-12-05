<?php

declare(strict_types=1);

namespace App\Services;

use App\Enum\UserRole;
use App\Models\Booking;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class BookingService
{
    public function getAllBooking(): Collection
    {
        $user = auth()->user();

        if ($user->role === UserRole::ADMIN->value) {
            return Booking::with(['user', 'service'])->get();
        } else {
            return $user->bookings()->with(['user', 'service'])->get();
        }

    }

    public function createBooking(array $data, int $userId): Booking
    {
        if (self::isAlreadyBookedWithSameDate((int) $data['service_id'], $data['booking_date'])) {
            throw new Exception('You have already booked this service on the same date.', 422);
        }

        return DB::transaction(function () use ($data, $userId) {
            return Booking::create([
                'user_id' => $userId,
                'service_id' => $data['service_id'],
                'booking_date' => $data['booking_date'],
                'status' => 'pending',
            ]);
        });
    }

    public function isAlreadyBookedWithSameDate(int $service_id, string $bookingDate): bool
    {
        return Booking::where('user_id', auth()->id())
            ->where('service_id', $service_id)
            ->whereDate('booking_date', $bookingDate)
            ->exists();
    }
}
