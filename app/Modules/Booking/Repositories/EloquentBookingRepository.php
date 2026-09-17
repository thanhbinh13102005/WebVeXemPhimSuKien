<?php

namespace App\Modules\Booking\Repositories;

use App\Modules\Booking\Models\ShowtimeSeat;
use App\Modules\Booking\Models\Booking;
use App\Modules\Booking\Models\BookingSeat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * NGUOI 3 phu trach - module quan trong nhat (dat ve, giu ghe).
 * Doi sang NoSQL: giu logic trong Service, chi viet lai class nay.
 */
class EloquentBookingRepository implements BookingRepositoryInterface
{
    public function getSeatsForShowtime(int $showtimeId)
    {
        // Tu dong nha ghe het han giu truoc khi tra ve danh sach
        $this->releaseExpiredHolds();

        return ShowtimeSeat::with("seat")
            ->where("showtime_id", $showtimeId)
            ->get();
    }

    public function holdSeats(int $showtimeId, array $seatIds, int $userId, int $minutes)
    {
        return DB::transaction(function () use ($showtimeId, $seatIds, $userId, $minutes) {
            $seats = ShowtimeSeat::whereIn("id", $seatIds)
                ->where("showtime_id", $showtimeId)
                ->where("status", "available")
                ->lockForUpdate()
                ->get();

            if ($seats->count() !== count($seatIds)) {
                throw new \RuntimeException("Mot so ghe da duoc giu boi nguoi khac, vui long chon lai.");
            }

            foreach ($seats as $seat) {
                $seat->update([
                    "status"     => "holding",
                    "held_by"    => $userId,
                    "held_until" => now()->addMinutes($minutes),
                ]);
            }

            return $seats;
        });
    }

    public function releaseExpiredHolds(): void
    {
        ShowtimeSeat::where("status", "holding")
            ->where("held_until", "<", now())
            ->update(["status" => "available", "held_by" => null, "held_until" => null]);
    }

    public function confirmBooking(int $userId, int $showtimeId, array $seatIds, float $totalPrice, ?int $voucherId = null)
    {
        return DB::transaction(function () use ($userId, $showtimeId, $seatIds, $totalPrice, $voucherId) {
            $booking = Booking::create([
                "user_id"     => $userId,
                "showtime_id" => $showtimeId,
                "voucher_id"  => $voucherId,
                "total_price" => $totalPrice,
                "status"      => "confirmed",
                "ticket_code" => strtoupper(Str::random(8)),
            ]);

            foreach ($seatIds as $seatId) {
                BookingSeat::create(["booking_id" => $booking->id, "showtime_seat_id" => $seatId]);
                ShowtimeSeat::where("id", $seatId)->update(["status" => "booked"]);
            }

            return $booking;
        });
    }

    public function history(int $userId)
    {
        return Booking::with("seats")->where("user_id", $userId)->latest()->get();
    }
}
