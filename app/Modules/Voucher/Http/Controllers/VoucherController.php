<?php

namespace App\Modules\Voucher\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Voucher\Services\VoucherService;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function __construct(protected VoucherService $voucherService) {}

    // AJAX: kiem tra + tinh gia khi user nhap ma voucher o trang gio hang
    public function apply(Request $request)
    {
        $data = $request->validate([
            "code"         => "required|string",
            "order_total"  => "required|numeric",
        ]);

        try {
            $result = $this->voucherService->validateAndCalculate($data["code"], $data["order_total"]);
            return response()->json(["success" => true] + $result);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(["success" => false, "message" => $e->getMessage()], 422);
        }
    }
}
