<?php

namespace App\Modules\Booking\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = ["room_name", "seat_code", "seat_type"];
}
