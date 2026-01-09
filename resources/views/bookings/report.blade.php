@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Booking Report</h4>
</div>

<div class="row g-4">
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Guest Name</th>
                        <th>Phone</th>
                        <th>Room</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Adults</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $booking)
                        <tr>
                            <td>{{ $booking->guest_name }}</td>
                            <td>{{ $booking->phone }}</td>
                            <td>{{ $booking->room->room_number  ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}</td>
                             <td>{{ $booking->adults }}</td>
                            <td>
                                @if($booking->status == 1)
                                    <span class="badge bg-success">Confirmed</span>
                                @elseif($booking->status == 0)
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($booking->status == 2)
                                    <span class="badge bg-danger">Cancelled</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-primary">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No bookings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
