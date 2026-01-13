@extends('layouts.app')

@section('content')

{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Dashboard</h4>
        <p class="text-muted mb-0">
            Welcome back, {{ auth()->user()->name }} 👋
        </p>
    </div>
    <span class="badge bg-light text-dark">
        {{ now()->format('d M Y') }}
    </span>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <p class="text-muted mb-1">Total Bookings</p>
                   <h4 class="mb-0">{{ $stats['totalBookings'] }}</h4>

                </div>
                <div class="text-primary fs-3">
                    <i class="bi bi-calendar-check"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <p class="text-muted mb-1">Available Rooms</p>
                    <h4 class="mb-0">{{ $stats['availableRooms'] }}</h4>

                </div>
                <div class="text-success fs-3">
                    <i class="bi bi-door-open"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <p class="text-muted mb-1">Occupied Rooms</p>
                    <h4 class="mb-0">{{ $stats['occupiedRooms'] }}</h4>

                </div>
                <div class="text-warning fs-3">
                    <i class="bi bi-building"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <p class="text-muted mb-1">Monthly Revenue</p>
                    <h4 class="mb-0">
                    ₹ {{ number_format($stats['monthlyRevenue'], 2) }}
                </h4>

                </div>
                <div class="text-danger fs-3">
                    <i class="bi bi-currency-rupee"></i>
                </div>
            </div>
        </div>
    </div> --}}
</div>

{{-- Bookings & Actions --}}
<div class="row g-4">
    {{-- Recent Bookings --}}
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between">
                <h6 class="mb-0">Recent Bookings</h6>
                <a href="{{ route('bookings.report') }}" class="btn btn-sm btn-outline-primary">
                    View All
                </a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Sr. No</th>
                            <th>Guest Name/ Company</th>
                            <th>Room</th>
                            <th>Check-in</th>
                            <th>Status</th>
                             <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <th>{{ $report->guest_name }}</th>
                            <td>{{ $report->room->room_number  }}</td>
                            <td>{{ $report->check_in }}</td>
                            <td>
                                @if($report->status == 1)
                                    <span class="badge bg-success">Confirmed</span>
                                @elseif($report->status == 0)
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($report->status == 2)
                                    <span class="badge bg-danger">Cancelled</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('bookings.show', $report->id) }}" class="btn btn-sm btn-outline-secondary">
                                    View
                                </a>
                            </td>
                        </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h6 class="mb-0">Quick Actions</h6>
            </div>
            <div class="card-body d-grid gap-3">
                <a href="{{ route('bookings.calendar') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i> New Booking
                </a>
                <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-door-closed me-2"></i> Manage Rooms
                </a>
                <a href="{{ route('reports.index') }}" class="btn btn-outline-success">
                    <i class="bi bi-graph-up me-2"></i> View Reports
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
