<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("vouchers", function (Blueprint $table) {
            $table->id();
            $table->string("code")->unique();
            $table->enum("discount_type", ["percent", "fixed"]);
            $table->decimal("discount_value", 10, 2);
            $table->decimal("max_discount_value", 10, 2)->nullable();
            $table->decimal("min_order_value", 10, 2)->default(0);
            $table->integer("usage_limit")->nullable();
            $table->integer("used_count")->default(0);
            $table->date("start_date");
            $table->date("end_date");
            $table->boolean("is_active")->default(true);
            $table->timestamps();
        });

        Schema::create("payments", function (Blueprint $table) {
            $table->id();
            $table->foreignId("booking_id")->constrained()->cascadeOnDelete();
            $table->decimal("amount", 10, 2);
            $table->enum("method", ["cash", "momo", "vnpay"]);
            $table->enum("status", ["pending", "success", "failed"])->default("pending");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("payments");
        Schema::dropIfExists("vouchers");
    }
};
