<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'room_id',
        'booked_by',
        'guest_name',
        'email',
        'phone',
        'check_in',
        'check_out',
        'adults',
        'children',
        'meal_plan',
        'status',
        'notes',
        'total_amount',
        'refund_amount',
        'status',
        'cancellation_reason',
        'booking_number',
        'advance',
        'payment_mode',
        'receptionist_name',
        'payment_person',

    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function bookedBy()
    {
        return $this->belongsTo(User::class, 'booked_by');
    }
    public function scopeConfirmed($query)
{
    return $query->where('status', 1);
}

}