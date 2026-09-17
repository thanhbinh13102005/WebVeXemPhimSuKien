<?php

namespace App\Modules\Booking\Models;

use Illuminate\Database\Eloquent\Model;

class BookingSeat extends Model
{
    protected $fillable = ["booking_id", "showtime_seat_id"];
}
