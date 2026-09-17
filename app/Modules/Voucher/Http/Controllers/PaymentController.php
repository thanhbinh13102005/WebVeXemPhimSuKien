<?php

namespace App\Modules\Voucher\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Voucher\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Thanh toan gia lap (chua tich hop cong thanh toan that)
    public function pay(Request $request, int $bookingId)
    {
        $data = $request->validate([
            "amount" => "required|numeric",
            "method" => "required|in:cash,momo,vnpay",
        ]);

        Payment::create([
            "booking_id" => $bookingId,
            "amount"     => $data["amount"],
            "method"     => $data["method"],
            "status"     => "success",
        ]);

        return redirect()->route("booking.history")->with("success", "Thanh toan thanh cong.");
    }
}
