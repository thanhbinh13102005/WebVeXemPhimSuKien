<?php

namespace App\Modules\Booking\Services;

use App\Modules\Booking\Repositories\BookingRepositoryInterface;

class BookingService
{
    // So phut giu ghe tam thoi truoc khi tu dong nha
    const HOLD_MINUTES = 10;

    public function __construct(protected BookingRepositoryInterface $bookingRepo) {}

    public function seatMap(int $showtimeId)
    {
        return $this->bookingRepo->getSeatsForShowtime($showtimeId);
    }

    public function holdSeats(int $showtimeId, array $seatIds, int $userId)
    {
        return $this->bookingRepo->holdSeats($showtimeId, $seatIds, $userId, self::HOLD_MINUTES);
    }

    public function confirm(int $userId, int $showtimeId, array $seatIds, float $totalPrice, ?int $voucherId = null)
    {
        return $this->bookingRepo->confirmBooking($userId, $showtimeId, $seatIds, $totalPrice, $voucherId);
    }

    public function history(int $userId)
    {
        return $this->bookingRepo->history($userId);
    }
}
