<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $memberCount = \App\Models\Member::count();
        $bookCount = \App\Models\Book::count();
        // Placeholder for loans
        $loanCount = \App\Models\Loan::where('status', 'active')->count();

         // Chart Data (Last 7 Days)
         $labels = [];
         $data = [];
         
         for ($i = 6; $i >= 0; $i--) {
             $date = \Carbon\Carbon::now()->subDays($i);
             $labels[] = $date->isoFormat('dddd'); 
             
             $count = \Illuminate\Support\Facades\DB::table('attendances')
                         ->whereDate('scanned_at', $date->format('Y-m-d'))
                         ->count();
             $data[] = $count;
        }

        // Recent Activity for Dashboard
         $recentLoans = \App\Models\Loan::with(['member', 'book'])->latest()->take(5)->get();
         $recentAttendances = \App\Models\Attendance::with('member')->latest('scanned_at')->take(5)->get();

        return view('staff.index', compact('memberCount', 'bookCount', 'loanCount', 'labels', 'data', 'recentLoans', 'recentAttendances'));
    }
}
