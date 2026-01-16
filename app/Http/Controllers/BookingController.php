<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Mail\BookingConfirmed;
use Illuminate\Support\Facades\Mail;


class BookingController extends Controller
{
   
    public function index()
    {
      return view('bookings.calendar');
    }

 public function events()
{
    $bookings = Booking::with('room')->latest()->take(5)->get();

    return response()->json(
        $bookings->map(function ($booking) {
            return [
                'id'    => $booking->id,
                'title' => $booking->room->room_number . ' - ' . $booking->guest_name,
                'start' => $booking->check_in,
                'end'   => $booking->check_out,
                'color' => match ($booking->status) {
                    1 => '#198754',
                    0 => '#ffc107',
                    2 => '#dc3545',
                    default => '#6c757d',
                },
             
                'url' => route('bookings.show', $booking->id),
            ];
        })
    );
}



   public function roomsByDate($date)
    {
        $date = Carbon::parse($date);

        $rooms = Room::all();

        $bookedRoomIds = Booking::where('status', '!=', 2) // not cancelled
            ->whereDate('check_in', '<=', $date)
            ->whereDate('check_out', '>', $date)
            ->pluck('room_id')
            ->toArray();

        return response()->json(
            $rooms->map(function ($room) use ($bookedRoomIds) {
                return [
                    'id' => $room->id,
                    'room_number' => $room->room_number,
                    'type' => $room->type,
                    'booked' => in_array($room->id, $bookedRoomIds),
                ];
            })
        );
    }

public function store(Request $request)
{
    $request->validate([
        'room_id' => 'required|exists:rooms,id',
        'check_in' => 'required|date',
        'guest_name' => 'required|string',
        'guest_email' => 'nullable|email',
        'phone' => 'required|string',
        'notes' => 'nullable|string',
        'meal_plan' => 'nullable|string',
        'check_out' => 'required|date|after:check_in',
        'advance' => 'required|numeric|min:0',
        'payment_mode' => 'required|string',
        'receptionist_name' => 'required|string',
        'payment_person' => 'nullable|string',



    ]);

      $booking = Booking::create([
        'room_id' => $request->room_id,
        'check_in' => $request->check_in,
        'check_out' => $request->check_out, 
        'guest_name' => $request->guest_name,
        'email' => $request->guest_email,
        'phone' => $request->phone,
        'meal_plan' => $request->meal_plan,
        'status' => 1,
        'notes' => $request->notes,
        'advance' => $request->advance,
        'payment_mode' => $request->payment_mode,
        'receptionist_name' => $request->receptionist_name,
        'payment_person' => $request->payment_person,
        'total_amount' => $request->total_amount,
        'booking_number' => 'BK' . strtoupper(uniqid()),
        'booked_by' => auth()->id(),

    ]);

    // ✅ Send Email (only if email exists)
    if ($booking->email) {
        Mail::to($booking->email)->send(new BookingConfirmed($booking));
    }


    return response()->json(['success' => true]);
}
   
}