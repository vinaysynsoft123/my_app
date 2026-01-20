@extends('layouts.app')

@section('content')

<h4 class="mb-4 fw-bold">Reports Overview</h4>

{{-- ================= FILTER ================= --}}
<form method="GET" class="row g-3 mb-4 align-items-end">
    <div class="col-md-3">
        <label class="form-label">Year</label>
        <select name="year" class="form-select">
            @for($y = now()->year; $y >= 2023; $y--)
                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                    {{ $y }}
                </option>
            @endfor
        </select>
    </div>

    <div class="col-md-3">
        <label class="form-label">Month</label>
        <select name="month" class="form-select">
            <option value="">All Months</option>
            @for($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                    {{ date('F', mktime(0,0,0,$m,1)) }}
                </option>
            @endfor
        </select>
    </div>

    <div class="col-md-3">
        <button class="btn btn-primary">
            <i class="bi bi-filter"></i> Apply Filter
        </button>
    </div>
</form>

{{-- ================= SUMMARY CARDS ================= --}}
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <small>Total Bookings</small>
                <h3>{{ $totalBookings }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <small>Confirmed</small>
                <h3 class="text-success">{{ $confirmedBookings }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <small>Cancelled</small>
                <h3 class="text-danger">{{ $cancelledBookings }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <small>Total Revenue</small>
                <h3 class="text-success">
                    ₹ {{ number_format($totalRevenue, 2) }}
                </h3>
            </div>
        </div>
    </div>
</div>

{{-- ================= CHARTS ================= --}}
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header fw-semibold">Bookings by Month</div>
            <div class="card-body">
                <canvas id="bookingChart" height="120"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header fw-semibold">Revenue by Month</div>
            <div class="card-body">
                <canvas id="revenueChart" height="120"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection

{{-- ================= SCRIPTS ================= --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const bookingCtx = document.getElementById('bookingChart');
    const revenueCtx = document.getElementById('revenueChart');

    if (!bookingCtx || !revenueCtx) {
        console.error('Canvas not found');
        return;
    }

    const labels = {!! json_encode(
        $monthlyBookings->keys()->map(fn($m) => date('F', mktime(0,0,0,$m,1)))
    ) !!};

    const bookingData = {!! json_encode($monthlyBookings->values()) !!};
    const revenueData = {!! json_encode($monthlyRevenue->values()) !!};

    new Chart(bookingCtx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Bookings',
                data: bookingData,
                backgroundColor: '#0d6efd'
            }]
        }
    });

    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Revenue (₹)',
                data: revenueData,
                borderColor: '#198754',
                backgroundColor: 'rgba(25,135,84,0.2)',
                tension: 0.4,
                fill: true
            }]
        }
    });

});
</script>
