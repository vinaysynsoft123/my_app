<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Carbon\Carbon;


class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      return view('bookings.calendar');
    }

    public function events()
    {
        $bookings = Booking::with('room')->get();

        return response()->json(
            $bookings->map(function ($booking) {
                return [
                    'title' => $booking->room->room_number . ' - ' . $booking->guest_name,
                    'start' => $booking->check_in,
                    'end'   => $booking->check_out,
                    'color' => $booking->status == 1 ? '#198754' : '#ffc107',
                ];
            })
        );
    }


    public function roomsByDate($date)
{
    $date = Carbon::parse($date);

    $rooms = Room::all();

    $bookedRoomIds = Booking::whereDate('check_in', '<=', $date)
        ->whereDate('check_out', '>=', $date)
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
        'guest_email' => 'required|email',
        'guest_phone' => 'required|string',
    ]);

    Booking::create([
        'room_id' => $request->room_id,
        'check_in' => $request->check_in,
        'check_out' => $request->check_in, 
        'guest_name' => $request->guest_name,
        'guest_email' => $request->guest_email,
        'guest_phone' => $request->guest_phone,
        'status' => 1,
        'notes' => $request->notes,
        'total_amount' => 0,
        'booking_number' => 'BK' . strtoupper(uniqid()),
        'booked_by' => auth()->id(),

    ]);

    return response()->json(['success' => true]);
}


    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        //
    }
}
