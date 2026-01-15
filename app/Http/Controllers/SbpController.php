<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SbpController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\SbpRequest::query();

        // 1. Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 2. Filter by Date
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        // 3. Search Member Name (Optional if needed, but not requested explicitly, good to have)
        if ($request->filled('search')) {
            $query->whereHas('member', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%');
            });
        }

        $requests = $query->with('member')->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        
        return view('admin.sbp.index', compact('requests'));
    }

    public function update(Request $request, $id)
    {
        $sbp = \App\Models\SbpRequest::findOrFail($id);
        $data = [
            'status' => $request->status,
            'admin_note' => $request->admin_note
        ];

        // Generate Letter Number if Approved and not yet generated
        if ($request->status === 'approved' && is_null($sbp->letter_number)) {
            $year = date('Y');
            $month = date('n');
            
            // Get Sequence for this YEAR
            $count = \App\Models\SbpRequest::whereYear('created_at', $year)
                        ->whereNotNull('letter_number')
                        ->count();
            $seq = $count + 1;
            
            $romanMonths = ["", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];
            $romanMonth = $romanMonths[$month];
            
            $data['letter_number'] = sprintf("%03d/SBP/IHSAN-LIB/%s/%s", $seq, $romanMonth, $year);
        }

        $sbp->update($data);

        return back()->with('success', 'Status pengajuan berhasil diperbarui.');
    }

    public function print($id)
    {
        $sbp = \App\Models\SbpRequest::with('member')->findOrFail($id);
        if ($sbp->status !== 'approved') {
            return back()->with('error', 'Hanya pengajuan yang disetujui yang dapat dicetak.');
        }
        return view('admin.sbp.print', compact('sbp'));
    }
}
