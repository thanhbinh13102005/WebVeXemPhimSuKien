<?php

namespace App\Modules\Booking\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Booking\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(protected BookingService $bookingService) {}

    public function selectSeats(int $showtimeId)
    {
        $seats = $this->bookingService->seatMap($showtimeId);
        return view("booking-module.select-seats", compact("seats", "showtimeId"));
    }

    // AJAX: giu ghe tam thoi khi user click chon (phan mo rong)
    public function hold(Request $request, int $showtimeId)
    {
        $data = $request->validate(["seat_ids" => "required|array"]);

        try {
            $this->bookingService->holdSeats($showtimeId, $data["seat_ids"], auth()->id());
            return response()->json(["success" => true]);
        } catch (\RuntimeException $e) {
            return response()->json(["success" => false, "message" => $e->getMessage()], 409);
        }
    }

    public function confirm(Request $request, int $showtimeId)
    {
        $data = $request->validate([
            "seat_ids"    => "required|array",
            "total_price" => "required|numeric",
        ]);

        $booking = $this->bookingService->confirm(
            auth()->id(),
            $showtimeId,
            $data["seat_ids"],
            $data["total_price"]
        );

        return redirect()->route("booking.history")->with("success", "Dat ve thanh cong! Ma ve: " . $booking->ticket_code);
    }

    public function history()
    {
        $bookings = $this->bookingService->history(auth()->id());
        return view("booking-module.history", compact("bookings"));
    }
}
