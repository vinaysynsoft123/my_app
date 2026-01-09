<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            // Relations
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->foreignId('booked_by')->constrained('users')->cascadeOnDelete();

            // Guest info
            $table->string('guest_name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            // Booking dates
            $table->date('check_in');
            $table->date('check_out')->nullable();

            // Guests
            $table->unsignedTinyInteger('adults')->default(1);
            $table->unsignedTinyInteger('children')->default(0);

            // Extra
            $table->string('meal_plan')->nullable();
            $table->tinyInteger('status')->default(1);
            // 1 = Confirmed, 0 = Pending, 2 = Cancelled

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
