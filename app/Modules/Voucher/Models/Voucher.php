<?php

namespace App\Modules\Voucher\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        "code", "discount_type", "discount_value", "max_discount_value",
        "min_order_value", "usage_limit", "used_count",
        "start_date", "end_date", "is_active",
    ];

    protected $casts = ["start_date" => "date", "end_date" => "date", "is_active" => "boolean"];
}
