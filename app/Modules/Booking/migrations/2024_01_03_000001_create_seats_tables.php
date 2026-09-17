<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("seats", function (Blueprint $table) {
            $table->id();
            $table->string("room_name");
            $table->string("seat_code");
            $table->enum("seat_type", ["standard", "vip", "couple"])->default("standard");
            $table->timestamps();
        });

        Schema::create("showtime_seats", function (Blueprint $table) {
            $table->id();
            $table->foreignId("showtime_id")->constrained()->cascadeOnDelete();
            $table->foreignId("seat_id")->constrained()->cascadeOnDelete();
            $table->enum("status", ["available", "holding", "booked"])->default("available");
            $table->unsignedBigInteger("held_by")->nullable();
            $table->timestamp("held_until")->nullable();
            $table->timestamps();
        });

        Schema::create("bookings", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->cascadeOnDelete();
            $table->foreignId("showtime_id")->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger("voucher_id")->nullable();
            $table->decimal("total_price", 10, 2);
            $table->enum("status", ["pending", "confirmed", "cancelled"])->default("pending");
            $table->string("ticket_code")->unique();
            $table->timestamps();
        });

        Schema::create("booking_seats", function (Blueprint $table) {
            $table->id();
            $table->foreignId("booking_id")->constrained()->cascadeOnDelete();
            $table->foreignId("showtime_seat_id")->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("booking_seats");
        Schema::dropIfExists("bookings");
        Schema::dropIfExists("showtime_seats");
        Schema::dropIfExists("seats");
    }
};
