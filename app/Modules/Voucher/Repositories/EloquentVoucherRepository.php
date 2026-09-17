<?php

namespace App\Modules\Voucher\Repositories;

use App\Modules\Voucher\Models\Voucher;

/**
 * NGUOI 4 phu trach.
 */
class EloquentVoucherRepository implements VoucherRepositoryInterface
{
    public function findByCode(string $code)
    {
        return Voucher::where("code", $code)->where("is_active", true)->first();
    }

    public function incrementUsage(int $voucherId)
    {
        Voucher::where("id", $voucherId)->increment("used_count");
    }
}
