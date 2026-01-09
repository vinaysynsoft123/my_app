<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $year  = $request->year ?? now()->year;
        $month = $request->month; // optional

        // ================= BASE QUERY =================
        $baseQuery = Booking::whereYear('created_at', $year);

        if ($month) {
            $baseQuery->whereMonth('created_at', $month);
        }

        // ================= SUMMARY COUNTS =================
        $totalBookings = (clone $baseQuery)->count();

        $confirmedBookings = (clone $baseQuery)
            ->where('status', 1)
            ->count();

        $cancelledBookings = (clone $baseQuery)
            ->where('status', 2) // assuming 2 = cancelled
            ->count();

        $totalRevenue = (clone $baseQuery)
            ->where('status', 1)
            ->sum('total_amount');

        // ================= MONTHLY BOOKINGS =================
        $monthlyBookings = Booking::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', $year)
            ->when($month, fn($q) => $q->whereMonth('created_at', $month))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        // ================= MONTHLY REVENUE =================
        $monthlyRevenue = Booking::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_amount) as total')
            )
            ->whereYear('created_at', $year)
            ->where('status', 1)
            ->when($month, fn($q) => $q->whereMonth('created_at', $month))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        return view('reports.index', compact(
            'year',
            'month',
            'totalBookings',
            'confirmedBookings',
            'cancelledBookings',
            'totalRevenue',
            'monthlyBookings',
            'monthlyRevenue'
        ));
    }
}
