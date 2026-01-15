<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $memberCount = \App\Models\Member::count();
        $bookCount = \App\Models\Book::count();
        // Real Loans Check
        $loanCount = \App\Models\Loan::where('status', 'active')->count();

        // Real Chart Data (Last 7 Days)
        $labels = [];
        $data = [];
        $today = \Carbon\Carbon::today();

        for ($i = 6; $i >= 0; $i--) {
             $date = $today->copy()->subDays($i);
             // Use Indonesian day names if Locale is set, or manually map
             $labels[] = $date->isoFormat('dddd'); 
             
             // Fetch count from Attendance model or table
             // DB Schema confirmed: uses 'scanned_at' (datetime), not 'date'.
             $count = \Illuminate\Support\Facades\DB::table('attendances')
                         ->whereDate('scanned_at', $date->format('Y-m-d'))
                         ->count();
             $data[] = $count;
        }

        // Recent Activity for Dashboard
        $recentLoans = \App\Models\Loan::with(['member', 'book'])->latest()->take(5)->get();
        $recentAttendances = \App\Models\Attendance::with('member')->latest('scanned_at')->take(5)->get();

        // Pass to view
        return view('admin.index', compact('memberCount', 'bookCount', 'loanCount', 'labels', 'data', 'recentLoans', 'recentAttendances'));
    }
}
