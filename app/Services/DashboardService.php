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
        ];
    }

    public function recentBookings(int $limit = 5)
    {
        return Booking::with('room')
            ->latest()
            ->take($limit)
            ->get();
    }
}
