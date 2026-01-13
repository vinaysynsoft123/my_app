<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('advance', 10, 2)->nullable()->after('total_amount');
            $table->string('payment_mode')->nullable()->after('advance');
            $table->string('receptionist_name')->nullable()->after('payment_mode');
            $table->string('payment_person')->nullable()->after('receptionist_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
             $table->dropColumn([
                'advance',
                'payment_mode',
                'receptionist_name',
                'payment_person',
            ]);
        });
    }
};
