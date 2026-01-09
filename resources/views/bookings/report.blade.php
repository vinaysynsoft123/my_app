@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Booking Report</h4>      
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Sr No</th>
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
                                <td>{{ $loop->iteration + ($reports->currentPage() - 1) * $reports->perPage() }}</td>
                                <td>{{ $booking->guest_name ?? '—' }}</td>
                                <td>{{ $booking->phone ?? '—' }}</td>
                                <td>{{ $booking->room->room_number ?? 'N/A' }}</td>
                                <td>{{ $booking->check_in ? \Carbon\Carbon::parse($booking->check_in)->format('d M Y') : '—' }}</td>
                                <td>{{ $booking->check_out ? \Carbon\Carbon::parse($booking->check_out)->format('d M Y') : '—' }}</td>
                                <td class="text-center">{{ $booking->adults ?? '—' }}</td>
                                <td>
                                    @if($booking->status == 1)
                                        <span class="badge bg-success px-3 py-2">Confirmed</span>
                                    @elseif($booking->status == 0)
                                        <span class="badge bg-warning text-dark px-3 py-2">Pending</span>
                                    @elseif($booking->status == 2)
                                        <span class="badge bg-danger px-3 py-2">Cancelled</span>
                                    @else
                                        <span class="badge bg-secondary px-3 py-2">Unknown</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('bookings.show', $booking->id) }}" 
                                       class="btn btn-sm btn-primary px-3">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-calendar-x me-2"></i>
                                    No bookings found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center px-3 py-3 bg-light border-top">
                <div class="text-muted small">
                    Page {{ $reports->currentPage() }} of {{ $reports->lastPage() }}
                </div>
                <div>
                    {{ $reports->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>


@endsection