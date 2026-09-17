<?php

namespace App\Modules\Voucher\Services;

use App\Modules\Voucher\Repositories\VoucherRepositoryInterface;
use Illuminate\Validation\ValidationException;

class VoucherService
{
    // Rang buoc: hien tai chi cho phep AP DUNG 1 VOUCHER / DON
    // Neu can nhieu voucher/don: doi tham so $code thanh mang va lap qua day,
    // nho cong don $maxApplied de gioi han so luong.

    public function __construct(protected VoucherRepositoryInterface $voucherRepo) {}

    public function validateAndCalculate(string $code, float $orderTotal): array
    {
        $voucher = $this->voucherRepo->findByCode($code);

        if (!$voucher) {
            throw ValidationException::withMessages(["voucher" => "Ma voucher khong ton tai hoac da bi khoa."]);
        }

        if (now()->lt($voucher->start_date) || now()->gt($voucher->end_date)) {
            throw ValidationException::withMessages(["voucher" => "Voucher da het han hoac chua den ngay ap dung."]);
        }

        if ($voucher->usage_limit !== null && $voucher->used_count >= $voucher->usage_limit) {
            throw ValidationException::withMessages(["voucher" => "Voucher da het luot su dung."]);
        }

        if ($orderTotal < $voucher->min_order_value) {
            throw ValidationException::withMessages([
                "voucher" => "Don hang can toi thieu " . number_format($voucher->min_order_value) . "đ de ap dung voucher nay.",
            ]);
        }

        $discount = $voucher->discount_type === "percent"
            ? min($orderTotal * $voucher->discount_value / 100, $voucher->max_discount_value ?? PHP_INT_MAX)
            : $voucher->discount_value;

        return [
            "voucher_id"  => $voucher->id,
            "discount"    => round($discount, 0),
            "final_total" => round($orderTotal - $discount, 0),
        ];
    }

    public function markUsed(int $voucherId): void
    {
        $this->voucherRepo->incrementUsage($voucherId);
    }
}
