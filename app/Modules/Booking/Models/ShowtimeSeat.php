<?php

namespace App\Modules\Booking\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Trang thai ghe THEO TUNG SUAT CHIEU (khong gan cung vao ghe vat ly),
 * vi 1 ghe co the trong o suat nay nhung da dat o suat khac.
 * status: available | holding | booked
 */
class ShowtimeSeat extends Model
{
    protected $fillable = ["showtime_id", "seat_id", "status", "held_by", "held_until"];

    protected $casts = ["held_until" => "datetime"];

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }
}
