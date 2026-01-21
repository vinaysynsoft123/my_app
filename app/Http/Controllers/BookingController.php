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
    $bookings = Booking::with('room')->latest()->get();

    $events = [];

    foreach ($bookings as $booking) {
        $events[] = [
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
    }
  
    $grouped = $bookings->groupBy(function ($b) {
        return \Carbon\Carbon::parse($b->check_in)->toDateString();
    });

    foreach ($grouped as $date => $dayBookings) {
        $count = $dayBookings->count();

        if ($count > 0) {
            $events[] = [
                'title'  => "Total - {$count}",
                'start'  => $date,
                'allDay' => true,
                'color'  => '#0d6efd', // blue summary
                'display'=> 'block',
            ];
        }
    }
    return response()->json($events);
}


public function roomsByDate($date)
{
    $date = Carbon::parse($date);

    $rooms = Room::all();

    // Get bookings for that date
    $bookings = Booking::where('status', '!=', 2)
        ->whereDate('check_in', '<=', $date)
        ->whereDate('check_out', '>=', $date)
        ->get()
        ->keyBy('room_id'); // IMPORTANT

    return response()->json(
        $rooms->map(function ($room) use ($bookings) {

            $booking = $bookings->get($room->id);

            return [
                'id' => $room->id,
                'room_number' => $room->room_number,
                'type' => $room->type,
                'booked' => $booking ? true : false,
                'guest_name' => $booking ? $booking->guest_name : null,
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
            'check_out' => 'required|date|after_or_equal:check_in',
            'advance' => 'required|numeric|min:0',
            'payment_mode' => 'required|string',
            'receptionist_name' => 'required|string',
            'payment_person' => 'nullable|string',
            'check_in_time' => 'nullable',
            'adults' => 'nullable|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'send_confirmation_email' => 'nullable|boolean',
        ]);

         //  Calculate nights
        $nights = Carbon::parse($request->check_in)
            ->diffInDays(Carbon::parse($request->check_out));

        $nights = max($nights, 1); // minimum 1 night

        //  Calculate total amount
        $total_amount = $request->tariff * $nights;
                                   

        $booking = Booking::create([
            'room_id' => $request->room_id,
            'check_in' => $request->check_in,
            'check_in_time' => $request->check_in_time,
            'check_out' => $request->check_out, 
            'guest_name' => $request->guest_name,
            'email' => $request->guest_email,
            'phone' => $request->phone,
            'meal_plan' => $request->meal_plan,
            'status' => 1,
            'adults' => $request->adults,
            'notes' => $request->notes,
            'advance' => $request->advance,
            'payment_mode' => $request->payment_mode,
            'receptionist_name' => $request->receptionist_name,
            'payment_person' => $request->payment_person,
            'tariff' => $request->tariff,
            'children' => $request->children,
            'total_amount' => $total_amount,
            'booking_number' => 'BK' . strtoupper(uniqid()),
            'booked_by' => auth()->id(),

        ]);
    
        if ($request->filled('send_confirmation_email') && $booking->email) {
            Mail::to($booking->email)->send(new BookingConfirmed($booking));
        }


        return response()->json(['success' => true]);
    }

public function edit(Booking $booking)
{
    return view('bookings.edit', compact('booking'));
}


  public function update(Request $request, $id)
{
    $booking = Booking::findOrFail($id);

    $request->validate([
        'room_id' => 'required|exists:rooms,id',
        'check_in' => 'required|date',
        'check_out' => 'required|date|after_or_equal:check_in',
        'guest_name' => 'required|string',
        'guest_email' => 'nullable|email',
        'phone' => 'required|string',
        'meal_plan' => 'nullable|string',
        'advance' => 'required|numeric|min:0',
        'payment_mode' => 'required|string',
        'receptionist_name' => 'required|string',
        'payment_person' => 'nullable|string',     
        'notes' => 'nullable|string',
        'check_in_time' => 'nullable',
        'adults' => 'nullable|integer|min:1',
        'children' => 'nullable|integer|min:0',
        'tariff' => 'required|numeric|min:100',
        
    ]);
     //  Calculate nights
        $nights = Carbon::parse($request->check_in)
            ->diffInDays(Carbon::parse($request->check_out));

        $nights = max($nights, 1); // minimum 1 night

        //  Calculate total amount
        $total_amount = $request->tariff * $nights;

    $booking->update([
        'room_id' => $request->room_id,
        'check_in' => $request->check_in,
        'check_out' => $request->check_out,
        'guest_name' => $request->guest_name,
        'email' => $request->guest_email,
        'phone' => $request->phone,
        'meal_plan' => $request->meal_plan,
        'notes' => $request->notes,
        'advance' => $request->advance,
        'payment_mode' => $request->payment_mode,
        'receptionist_name' => $request->receptionist_name,
        'payment_person' => $request->payment_person,
        'total_amount' => $total_amount,
        'check_in_time' => $request->check_in_time,
        'adults' => $request->adults,
        'children' => $request->children,
        'tariff' => $request->tariff,
    ]);

    return redirect()
        ->route('bookings.show', $booking->id)
        ->with('success', 'Booking updated successfully.');
}
    }