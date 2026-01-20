<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Setting;
use App\Models\Room;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;



class BookingReport extends Controller
{
   
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    $reports = Booking::with('room')
        ->latest()                    
        ->paginate(10);           

    return view('bookings.report', compact('reports'));
}

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        return view('bookings.show', compact('booking'));

    }

  public function print(Request $request, Booking $booking)
    {
        $setting = Setting::first();
        $booking->load('room');

        $pdf = Pdf::loadView('bookings.pdf', compact('booking', 'setting'));

        if ($request->has('download')) {
            return $pdf->download('booking-'.$booking->id.'.pdf');
        }
       
        return $pdf->stream('booking-'.$booking->id.'.pdf');
    }


      
    public function download(Booking $booking)
    {
        $setting = Setting::first();
        $booking->load('room');

        $pdf = Pdf::loadView('bookings.pdf', compact('booking', 'setting'));

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

    public function report(Request $request)
    {
        $reports = Booking::with('room')
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $query->where('guest_name', 'like', "%{$request->search}%")
                        ->orWhere('phone', 'like', "%{$request->search}%")
                        ->orWhere('booking_number', 'like', "%{$request->search}%");
                });
            })
            ->when($request->status !== null, function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->when($request->sort, function ($q) use ($request) {
                match ($request->sort) {
                    'oldest'   => $q->orderBy('id', 'asc'),
                    'check_in' => $q->orderBy('check_in', 'asc'),
                    default    => $q->orderBy('id', 'desc'),
                };
            }, fn ($q) => $q->orderBy('id', 'desc'))
            ->paginate(10)
            ->withQueryString();

        return view('bookings.report', compact('reports'));
    }


    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()
            ->route('bookings.report')
            ->with('success', 'Booking deleted successfully.');
    }
    
}