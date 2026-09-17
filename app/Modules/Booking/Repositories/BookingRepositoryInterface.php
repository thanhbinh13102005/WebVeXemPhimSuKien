<?php

namespace App\Modules\Booking\Repositories;

interface BookingRepositoryInterface
{
    public function getSeatsForShowtime(int $showtimeId);
    public function holdSeats(int $showtimeId, array $seatIds, int $userId, int $minutes);
    public function releaseExpiredHolds();
    public function confirmBooking(int $userId, int $showtimeId, array $seatIds, float $totalPrice, ?int $voucherId = null);
    public function history(int $userId);
}
