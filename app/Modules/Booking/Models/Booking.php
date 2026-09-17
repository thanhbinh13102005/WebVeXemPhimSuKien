<?php

namespace App\Modules\Booking\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ["user_id", "showtime_id", "voucher_id", "total_price", "status", "ticket_code"];

    public function seats()
    {
        return $this->hasMany(BookingSeat::class);
    }
}
