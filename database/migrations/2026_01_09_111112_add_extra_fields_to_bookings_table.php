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
            $table->string('booking_number')->unique()->after('id');
            $table->text('cancellation_reason')->nullable()->after('status');
            $table->decimal('total_amount', 10, 2)->default(0)->after('booking_number');
            $table->decimal('refund_amount', 10, 2)->default(0)->after('total_amount');
        });
    }
    /**
     * Reverse the migrations.
     */
   public function down(): void
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->dropColumn([
            'booking_number',
            'total_amount',
            'cancellation_reason',
            'refund_amount'
        ]);
    });
}
};
