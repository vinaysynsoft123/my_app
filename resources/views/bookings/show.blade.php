@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card receipt-card">
            <div class="card-body">
                @php
                    $statusText = match ($booking->status) {
                        1 => 'Confirmed',
                        0 => 'Pending',
                        default => 'Cancelled',
                    };

                    $statusClass = match ($booking->status) {
                        1 => 'bg-success',
                        0 => 'bg-warning text-dark',
                        default => 'bg-danger',
                    };
                @endphp
                <div class="row align-items-center mb-4">
                    <div class="col-md-6">
                        <h4 class="fw-bold ">Booking Receipt</h4>

                        <div class="text-muted small">
                            Booking No: <strong>#{{ $booking->booking_number }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <span class="badge {{ $statusClass }} px-2 py-1">
                            {{ $statusText }}
                        </span>
                        <div class="text-muted small mt-2">
                            Date: {{ $booking->created_at->format('d M Y') }}
                        </div>
                    </div>
                </div>

                <hr>
                <div class="">

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
                                Booking Number #{{ $booking->booking_number }}
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
                        <div class="row g-4 text-center">
                            <div class="col-md-4">
                                <div class="text-muted small mb-1">Check-in</div>
                                <div class="fs-4 fw-bold">
                                    {{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}
                                </div>
                                <div class="text-muted mb-1">
                                    Check-in Time: <span class="fw-semibold">
                                        {{ \Carbon\Carbon::parse($booking->check_in_time)->format('h:i A') }}</span>
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
                                    @php
                                        $duration = \Carbon\Carbon::parse($booking->check_in)->diffInDays(
                                            $booking->check_out,
                                        );
                                        $duration = $duration == 0 ? 1 : $duration;
                                    @endphp

                                    {{ $duration }} night{{ $duration > 1 ? 's' : '' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>


                    {{-- PAYMENT SUMMARY --}}
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="section-title mb-3">Receipt Info</h6>

                            <div class="info-row">
                                <span>Payment Mode</span>
                                <span>{{ $booking->payment_mode ?? 'N/A' }}</span>
                            </div>

                            <div class="info-row">
                                <span>Received By</span>
                                <span>{{ $booking->payment_person ?? 'N/A' }}</span>
                            </div>

                            <div class="info-row">
                                <span>Receptionist</span>
                                <span>{{ $booking->receptionist_name ?? 'N/A' }}</span>
                            </div>
                        </div>

                     <div class="col-md-6">
    <div class="card border-0 shadow-sm h-100">
        <div class="card-header bg-light d-flex align-items-center">
            <i class="bi bi-receipt fs-5 text-primary me-2"></i>
            <h6 class="mb-0 fw-semibold">Payment Summary</h6>
        </div>

        <div class="card-body">

            <!-- Tariff -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="text-muted">
                    Tariff
                    <small class="d-block">
                        ₹ {{ number_format($booking->tariff, 2) }} × {{ $duration }} night(s)
                    </small>
                </div>
                <span class="fw-semibold">
                    ₹ {{ number_format($booking->tariff * $duration, 2) }}
                </span>
            </div>

            <hr class="my-2">

            <!-- Total Amount -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-semibold">Total Amount</span>
                <span class="fw-bold fs-6 text-dark">
                    ₹ {{ number_format($booking->total_amount, 2) }}
                </span>
            </div>

            <!-- Advance -->
            <div class="d-flex justify-content-between align-items-center mb-2 text-success">
                <span>
                    <i class="bi bi-check-circle me-1"></i>
                    Advance Paid
                </span>
                <span class="fw-semibold">
                    − ₹ {{ number_format($booking->advance ?? 0, 2) }}
                </span>
            </div>

            <hr class="my-3">

            <!-- Balance -->
            <div class="d-flex justify-content-between align-items-center p-3 rounded bg-warning-subtle">
                <span class="fw-bold">
                    Balance Amount
                </span>
                <span class="fw-bold fs-5 text-danger">
                    ₹ {{ number_format($booking->total_amount - ($booking->advance ?? 0), 2) }}
                </span>
            </div>

        </div>
    </div>
</div>

                    </div>

                    @if ($booking->notes)
                        <hr>
                        <div>
                            <h6 class="text-muted mb-2">Notes</h6>
                            <div class="rounded p-3 bg-warning bg-opacity-10 ">
                                {{ $booking->notes }}
                            </div>
                        </div>
                    @endif

                    @if ($booking->cancellation_reason)
                        <hr>
                        <div>
                            <h6 class="text-muted mb-2">Cancellation Reason</h6>
                            <div class="border rounded p-3 bg-light">
                                {{ $booking->cancellation_reason }}
                            </div>
                        </div>
                    @endif

                </div>
                <div class="card-footer bg-white no-print text-end mt-2 border-0 px-0">
                    <div class="btn-group gap-2" role="group">
                        <a href="{{ route('bookings.download', $booking->id) }}" class="btn btn-dark">
                            <i class="bi bi-download"></i> Download
                        </a>

                        <a href="{{ route('bookings.download', $booking->id) }}" target="_blank" class="btn btn-primary">
                            <i class="bi bi-printer"></i> Print
                        </a>


                        @if ($booking->status != 2)
                            <button class="btn btn-danger"
                                onclick="openCancelModal('{{ route('bookings.cancel', $booking->id) }}')">
                                <i class="bi bi-x-circle"></i> Cancel
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('bookings.booking_cancel')

    <script>
        function openCancelModal(actionUrl) {
            const form = document.getElementById('cancelBookingForm');
            form.action = actionUrl;
            const modal = new bootstrap.Modal(document.getElementById('roomsModal'));
            modal.show();
        }
    </script>
@endsection
