<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class BookingReport extends Controller
{
   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $reports = Booking::with('room')->get();
      return view('bookings.report', compact('reports'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        return view('bookings.show', compact('booking'));

    }

        public function sendMail(Booking $booking)
    {
        // Mail::to($booking->email)->send(new BookingMail($booking));

        return back()->with('success', 'Booking email sent successfully.');
    }

    public function download(Booking $booking)
    {
        $booking->load('room');

        $pdf = Pdf::loadView('bookings.pdf', compact('booking'));

        return $pdf->download('booking-'.$booking->id.'.pdf');
    }

    public function cancel(Request $request, Booking $booking)
    {
        $request->validate([
            'cancellation_reason' => 'required|string|max:500',
            'refund_amount' => 'nullable|numeric|min:0',
        ]);

        $booking->update([
            'status' => 2, // Cancelled
            'cancellation_reason' => $request->cancellation_reason,
            'refund_amount' => $request->refund_amount ?? 0,
        ]);

        return redirect()
            ->route('bookings.show', $booking->id)
            ->with('success', 'Booking cancelled successfully.');
    }



}
