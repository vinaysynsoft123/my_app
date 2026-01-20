<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;

class DashboardService
{
   public function stats(): array
{
    $currentMonth = Carbon::now()->month;
    $currentYear  = Carbon::now()->year;

    return [
        'totalBookings' => Booking::count(),

        'availableRooms' => Room::where('status', 1)->count(),

        'occupiedRooms' => Booking::where('status', 1)
            ->whereDate('check_in', '<=', now())
            ->whereDate('check_out', '>=', now())
            ->count(),

        'monthlyRevenue' => Booking::where('status', 1)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('total_amount'),

        // ✅ ADD THIS
        'todayBookings' => $this->todayBookingCount(),
    ];
}


    public function recentBookings(int $limit = 10)
    {
        return Booking::with('room')
            ->latest()
            ->take($limit)
            ->get();
    }
 public function todayBookingCount()
{
    return Booking::whereDate('check_in', Carbon::today())
                  ->where('status', '!=', 2) // cancelled exclude
                  ->count();
}

// DashboardService.php
public function todayCheckIns(int $limit = 20)
{
    return Booking::with('room')
        ->whereDate('check_in', now())
        ->where('status', 1)
        ->orderBy('check_in')
        ->take($limit)
        ->get();
}
// DashboardService.php
public function todayCheckOuts(int $limit = 20)
{
    return Booking::with('room')
        ->whereDate('check_out', now())
        ->where('status', 1) // confirmed only
        ->orderBy('check_out')
        ->take($limit)
        ->get();
}


}