@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">Booking Details</h4>


    <div class="btn-group gap-2" role="group">
        <a href="{{ route('bookings.download', $booking->id) }}" class="btn btn-dark">
            <i class="bi bi-download"></i> Download
        </a>

        <form action="{{ route('bookings.sendMail', $booking->id) }}" method="POST">
            @csrf
            <button class="btn btn-primary">
                <i class="bi bi-envelope"></i> Send Mail
            </button>
        </form>

        @if($booking->status != 2)
        <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST"
              onsubmit="return confirm('Are you sure you want to cancel this booking?')">
            @csrf
            <button class="btn btn-danger">
                <i class="bi bi-x-circle"></i> Cancel
            </button>
        </form>
        @endif
    </div>
</div>

@php
    $statusText = match($booking->status) {
        1 => 'Confirmed',
        0 => 'Pending',
        default => 'Cancelled',
    };

    $statusClass = match($booking->status) {
        1 => 'bg-success',
        0 => 'bg-warning text-dark',
        default => 'bg-danger',
    };
@endphp

<div class="card shadow-sm">
    <div class="card-body">

        {{-- Guest & Room --}}
        <div class="row g-4">
            <div class="col-md-6">
                <h6 class="text-muted mb-2">Guest Information</h6>
                <div class="fw-semibold">{{ $booking->guest_name }}</div>
                <div class="text-muted small">{{ $booking->email }}</div>
                <div class="text-muted small">{{ $booking->phone }}</div>
            </div>

            <div class="col-md-6 text-md-end">
                <h6 class="text-muted mb-2">Room</h6>
                <div class="fw-semibold fs-5">
                    {{ $booking->room->room_number ?? 'N/A' }}
                </div>

                <div class="text-muted small">
              Booking Number  #{{ $booking->booking_number  }}
                </div>
            </div>
        </div>

        <hr>

        {{-- Occupancy --}}
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="text-muted small">Adults</div>
                <div class="fw-bold fs-5">{{ $booking->adults }}</div>
            </div>

            <div class="col-md-4">
                <div class="text-muted small">Children</div>
                <div class="fw-bold fs-5">{{ $booking->children ?? 0 }}</div>
            </div>

            <div class="col-md-4">
                <div class="text-muted small">Meal Plan</div>
                <div class="fw-bold fs-5">{{ $booking->meal_plan ?? 'N/A' }}</div>
            </div>
        </div>



        {{-- Dates --}}
       <div class="col-12">
                    <hr class="my-4">
                    <div class="row g-4 text-center text-md-start">
                        <div class="col-md-4">
                            <div class="text-muted small mb-1">Check-in</div>
                            <div class="fs-4 fw-bold">
                                {{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}
                            </div>
                            <div class="small text-muted">
                                {{ \Carbon\Carbon::parse($booking->check_in)->format('l') }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="text-muted small mb-1">Check-out</div>
                            <div class="fs-4 fw-bold">
                                {{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}
                            </div>
                            <div class="small text-muted">
                                {{ \Carbon\Carbon::parse($booking->check_out)->format('l') }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="text-muted small mb-1">Duration</div>
                            <div class="fs-4 fw-bold">
                                {{ \Carbon\Carbon::parse($booking->check_in)->diffInDays($booking->check_out) }} nights
                            </div>
                        </div>
                    </div>
                </div>

        <hr>

        {{-- Status & Amount --}}
        <div class="row align-items-center g-4">
            <div class="col-md-4">
                <div class="text-muted small">Status</div>
                <span class="badge {{ $statusClass }} px-3 py-2">
                    {{ $statusText }}
                </span>
            </div>

            <div class="col-md-4 text-md-center">
                <div class="text-muted small">Booked On</div>
                <div class="fw-semibold">
                    {{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}
                </div>
            </div>

            <div class="col-md-4 text-md-end">
                <div class="text-muted small">Total Amount</div>
                <div class="fs-4 fw-bold text-success">
                    ₹ {{ number_format($booking->total_amount, 2) }}
                </div>
            </div>
        </div>

        @if($booking->notes)
        <hr>
        <div>
            <div class="text-muted small mb-1">Notes</div>
            <div class="border rounded p-3 bg-light">
                {{ $booking->notes }}
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
