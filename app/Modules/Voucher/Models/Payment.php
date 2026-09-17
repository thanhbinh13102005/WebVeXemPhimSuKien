<?php

namespace App\Modules\Voucher\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ["booking_id", "amount", "method", "status"];
}
