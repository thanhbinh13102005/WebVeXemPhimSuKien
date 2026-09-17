<?php

namespace App\Modules\Voucher\Repositories;

interface VoucherRepositoryInterface
{
    public function findByCode(string $code);
    public function incrementUsage(int $voucherId);
}
