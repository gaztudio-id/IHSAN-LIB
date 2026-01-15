<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $previewData = null;

        if ($request->has(['month', 'year'])) {
            $previewData = $this->getReportData($request->month, $request->year);
        }

        return view('admin.reports.index', compact('previewData'));
    }

    public function print(Request $request)
    {
        $data = $this->getReportData($request->month, $request->year);
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports.print', $data);
        return $pdf->stream('Laporan-Bulanan-' . $data['monthName'] . '-' . $data['year'] . '.pdf');
    }

    private function getReportData($month, $year)
    {
        // Prepare Date Range
        $startDate = "$year-$month-01";
        $endDate = date("Y-m-t", strtotime($startDate));
        
        // 1. New Members
        $newMembers = \App\Models\Member::whereBetween('created_at', ["$startDate 00:00:00", "$endDate 23:59:59"])->count();

        // 2. New Books
        $newBooks = \App\Models\Book::whereBetween('created_at', ["$startDate 00:00:00", "$endDate 23:59:59"])->count();
        
        // 3. Loans 
        $loansCount = \Illuminate\Support\Facades\DB::table('loans')
                        ->whereBetween('borrow_date', [$startDate, $endDate])
                        ->count();
                        
        $returnsCount = \Illuminate\Support\Facades\DB::table('loans')
                        ->whereBetween('return_date', [$startDate, $endDate])
                        ->where('status', 'returned')
                        ->count();

        // 4. Visits (Attendance)
        // Table has 'scanned_at' (datetime), no 'date' column in current DB schema.
        $visitsCount = \Illuminate\Support\Facades\DB::table('attendances')
                        ->whereBetween('scanned_at', ["$startDate 00:00:00", "$endDate 23:59:59"])
                        ->count();

        // 5. SBP Issued
        $sbpIssued = \App\Models\SbpRequest::where('status', 'approved')
                        ->whereBetween('updated_at', ["$startDate 00:00:00", "$endDate 23:59:59"])
                        ->count();

        $monthName = \DateTime::createFromFormat('!m', $month)->format('F');
        
        // Localization for Month Name (Manual map for Indonesian)
        $indoMonths = [
            'January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret', 'April' => 'April',
            'May' => 'Mei', 'June' => 'Juni', 'July' => 'Juli', 'August' => 'Agustus',
            'September' => 'September', 'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember'
        ];
        $monthNameIndo = $indoMonths[$monthName] ?? $monthName;

        return [
            'month' => $month,
            'year' => $year,
            'monthName' => $monthNameIndo,
            'newMembers' => $newMembers,
            'newBooks' => $newBooks,
            'loansCount' => $loansCount,
            'returnsCount' => $returnsCount,
            'visitsCount' => $visitsCount,
            'sbpIssued' => $sbpIssued,
            'generatedAt' => now()->format('d F Y H:i')
        ];
    }
}
