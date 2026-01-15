<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function index()
    {
        // Initialize View Variables (Default Null)
        $member = null;
        $activeLoans = [];
        $attendanceHistory = [];
        $totalAttendance = 0;
        $sbpRequest = null;
        $calculatedGrade = null;
        
        if (session('santri_logged_in') && session('santri_id')) {
            $member = \App\Models\Member::find(session('santri_id'));
            
            // STRICT VALIDATION: Ensure Member exists AND has valid data
            if ($member && !empty($member->name) && !empty($member->nis)) {
                // Fetch active loans (assuming status 'borrowed') - Adjust based on your Loan model
                $activeLoans = \App\Models\Loan::where('member_id', $member->id)
                                ->where('status', 'active') // FIXED STATUS
                                ->with('book')
                                ->get();
                                
                // Fetch attendance history
                $attendanceHistory = \App\Models\Attendance::where('member_id', $member->id)
                                    ->orderBy('created_at', 'desc')
                                    ->take(5)
                                    ->get();
                                    
                $totalAttendance = \App\Models\Attendance::where('member_id', $member->id)->count();
                
                // --- LOGIKA ANGKATAN & KELAS (REVISED) ---
                
                // 1. Determine Angkatan Source
                // Prioritize 'class_name' from DB if it is numeric (User input "15" means Angkatan 15)
                // Fallback to NIS first 2 digits if class_name is not a clean number.
                $dbAngkatan = $member->class_name; 
                $angkatanFromNis = intval(substr($member->nis, 0, 2));

                if (is_numeric($dbAngkatan) && intval($dbAngkatan) > 0) {
                    $angkatan = intval($dbAngkatan);
                } else {
                    $angkatan = $angkatanFromNis;
                }

                // 2. Calculate Entry Year
                // Base Year IBS: 2007 (Derived from: Angkatan 10 = Entry 2017)
                $entryYear = 2007 + $angkatan;

                // 3. Calculate Current Academic Year
                $currentYear = date('Y');
                $currentMonth = date('n'); // 1-12
                // If before July (Month < 7), current academic year started in previous calendar year.
                $academicYearStart = ($currentMonth < 7) ? $currentYear - 1 : $currentYear;
                
                // 4. Calculate Years in System
                $yearsElapsed = $academicYearStart - $entryYear;
                
                // 5. Calculate Grade (7 + years)
                // Year 0 (First year) = Grade 7
                $calculatedGrade = 7 + $yearsElapsed;

                // 6. Determine Display Status
                if ($yearsElapsed < 0) {
                     $kelasDisplay = "Calon Santri";
                } elseif ($calculatedGrade > 12) {
                     $kelasDisplay = "Alumni";
                } else {
                     $kelasDisplay = "Kelas " . $calculatedGrade;
                }
                
            // ... (Logic Angkatan above)
                
                // Override for display
                $member->class_name = $kelasDisplay; 
                $member->angkatan = $angkatan;

                // SBP Check
                $sbpRequest = \App\Models\SbpRequest::where('member_id', $member->id)
                                ->whereIn('status', ['pending', 'approved'])
                                ->latest()
                                ->first();
            } else {
                // SESSION GHOST FIX 1
                session()->forget(['santri_logged_in', 'santri_id', 'santri_nis', 'santri_name']);
                return redirect()->route('portal.index');
            }
        }
        
        // Fetch Categories for Filter
        $categories = \App\Models\Book::whereNotNull('category')->distinct()->orderBy('category')->pluck('category');

        return view('portal', compact('member', 'activeLoans', 'attendanceHistory', 'totalAttendance', 'sbpRequest', 'calculatedGrade', 'categories'));
    }

    public function login(Request $request)
    {
        // Allow 'nis' field to carry either NIS or RFID Code
        $input = trim($request->input('nis') ?? $request->input('rfid_code'));
        
        if (!$input) {
             return response()->json(['status' => 'error', 'message' => 'Silakan masukkan NIS atau Tap Kartu.'], 400);
        }

        \Illuminate\Support\Facades\Log::info('Login attempt', ['input' => $input]);

        // Check if input matches NIS OR RFID Code
        $member = \App\Models\Member::where('nis', $input)
                    ->orWhere('rfid_code', $input)
                    ->first();

        if ($member) {
            session(['santri_logged_in' => true, 'santri_id' => $member->id, 'santri_nis' => $member->nis, 'santri_name' => $member->name]);
            session()->save(); // Keep this for safety

            if ($request->expectsJson()) {
                // ... (Logic for JSON replication if needed, omitted for brevity as standard login doesn't need it) ...
                // Simplified JSON response for consistency if needed
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login berhasil',
                    'data' => ['redirect' => route('portal.index')]
                ]);
            }
            
            return redirect()->route('portal.index');
        }

        if ($request->expectsJson()) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan.'], 404);
        }
        
        return back()->with('error', 'NIS/Kartu tidak ditemukan.');
    }

    public function logout()
    {
        session()->forget(['santri_logged_in', 'santri_id', 'santri_nis', 'santri_name']);
        return redirect()->route('portal.index'); // Redirect instead of JSON for standard logout
    }

    public function storeAttendance(Request $request)
    {
        // Allow attendance by Code/NIS directly (Guest Mode) OR Session
        $code = trim($request->input('code') ?? $request->input('nis'));
        $memberId = null;

        if ($code) {
             // Find member by RFID or NIS
             $member = \App\Models\Member::where('nis', $code)->orWhere('rfid_code', $code)->first();
             if ($member) {
                 // --- SECURITY CHECK: OWNERSHIP (User Request) ---
                 // If User is Logged In, they MUST use their own card/NIS.
                 if (session('santri_logged_in') && session('santri_id')) {
                     if ($member->id != session('santri_id')) {
                         return response()->json([
                             'status' => 'error', 
                             'message' => 'Anda sedang login. Mohon gunakan NIS/Kartu Anda sendiri.'
                         ], 403);
                     }
                 }
                 // ------------------------------------------------

                 $memberId = $member->id;
             } else {
                 return response()->json(['status' => 'error', 'message' => 'Kartu/NIS tidak dikenali.'], 404);
             }
        } elseif (session('santri_id')) {
             // Fallback to session if no code provided
             $memberId = session('santri_id');
        } else {
             return response()->json(['status' => 'error', 'message' => 'Silakan scan kartu.'], 400);
        }

        $today = now()->toDateString();
        // Check using scanned_at date part since 'date' column is missing
        $exists = \App\Models\Attendance::where('member_id', $memberId)
                    ->whereDate('scanned_at', $today)
                    ->exists();

        if ($exists) {
            return response()->json(['status' => 'warning', 'message' => 'Anda sudah absen hari ini.']);
        }

        \App\Models\Attendance::create([
            'member_id' => $memberId,
            'scanned_at' => now(),
        ]);
        
        // Find member name for response
        $memberName = \App\Models\Member::find($memberId)->name ?? 'Anggota';

        return response()->json(['status' => 'success', 'message' => 'Halo ' . $memberName . ', Absensi berhasil!']);
    }

    public function search(Request $request)
    {
        $query = \App\Models\Book::query();
        
        // Text Search (All fields)
        if ($request->filled('q')) {
            $term = trim($request->input('q'));
            $query->where(function($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('author', 'like', "%{$term}%")
                  ->orWhere('publisher', 'like', "%{$term}%")
                  ->orWhere('barcode', 'like', "%{$term}%");
            });
        }

        // Category Filter
        if ($request->filled('category')) {
             $query->where('category', $request->input('category'));
        }

        $books = $query->latest()->get();  
        return response()->json(['status' => 'success', 'data' => $books]);
    }

    public function storeLoan(Request $request)
    {
        try {
        $memberId = session('santri_id');
        if (!$memberId) return response()->json(['status' => 'error', 'message' => 'Sesi habis.'], 401);

        $bookCode = trim($request->input('book_code'));
        if (!$bookCode) return response()->json(['status' => 'error', 'message' => 'Kode buku wajib diisi.'], 400);

        // Lookup by ID OR BARCODE
        $book = \App\Models\Book::where('id', $bookCode)
                    ->orWhere('barcode', $bookCode) // Critical fix
                    ->first();

        if (!$book) {
            return response()->json(['status' => 'error', 'message' => 'Buku dengan kode/barcode tersebut tidak ditemukan.'], 404);
        }

        if ($book->stock <= 0) {
            return response()->json(['status' => 'error', 'message' => 'Stok buku habis.'], 400);
        }
        
        // Cek Double Loan (Same Book, Active Status)
        $existingLoan = \App\Models\Loan::where('member_id', $memberId)
                        ->where('book_id', $book->id)
                        ->where('status', 'active') // Fixed status
                        ->exists();
                        
        if ($existingLoan) {
             return response()->json(['status' => 'error', 'message' => 'Anda sedang meminjam buku ini.'], 400);
        }

        // Create Loan
        \App\Models\Loan::create([
            'member_id' => $memberId,
            'book_id' => $book->id,
            'borrow_date' => now(), // Fixed column
            'due_date' => now()->addDays(7),
            'status' => 'active' // Fixed status
        ]);

        // Decrement Stock
        $book->decrement('stock');

    // ... (Existing storeLoan logic above) ...
        return response()->json(['status' => 'success', 'message' => 'Peminjaman berhasil: ' . $book->title]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Loan Error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Gagal memproses: ' . $e->getMessage()], 500);
        }
    }

    // Endpoint for Loan Confirmation Step
    // Endpoint for Loan Confirmation Step
    public function checkBook(Request $request) 
    {
        try {
            $bookCode = trim($request->input('book_code'));
            if (!$bookCode) return response()->json(['status' => 'error', 'message' => 'Kode buku wajib diisi.'], 400);

            $book = \App\Models\Book::where('id', $bookCode)
                        ->orWhere('barcode', $bookCode)
                        ->first();

            if (!$book) return response()->json(['status' => 'error', 'message' => 'Buku tidak ditemukan.'], 404);
            if ($book->stock <= 0) return response()->json(['status' => 'error', 'message' => 'Stok buku habis.'], 400);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $book->id,
                    'title' => $book->title,
                    'barcode' => $book->barcode,
                    'stock' => $book->stock, // Added Stock
                    'loan_date' => now()->format('d-m-Y'), // Display Only (JSON Key can stay loan_date for JS compatibility, or change JS)
                    'due_date' => now()->addDays(7)->format('d-m-Y')
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Server Error: ' . $e->getMessage()], 500);
        }
    }

    // Endpoint for Return Confirmation Step
    public function checkReturn(Request $request)
    {
        try {
            $memberId = session('santri_id');
            if (!$memberId) return response()->json(['status' => 'error', 'message' => 'Sesi habis.'], 401);

            $bookCode = trim($request->input('book_code'));
            if (!$bookCode) return response()->json(['status' => 'error', 'message' => 'Kode buku wajib diisi.'], 400);

            $book = \App\Models\Book::where('id', $bookCode)
                        ->orWhere('barcode', $bookCode)
                        ->first();

            if (!$book) return response()->json(['status' => 'error', 'message' => 'Buku tidak ditemukan.'], 404);

            // Find Active Loan
            $loan = \App\Models\Loan::where('member_id', $memberId)
                        ->where('book_id', $book->id)
                        ->where('status', 'active') // Fixed status
                        ->first();

            if (!$loan) {
                return response()->json(['status' => 'error', 'message' => 'Buku ini tidak sedang Anda pinjam.'], 400);
            }

            // Calculate Preview
            $returnDate = now();
            $dueDate = \Carbon\Carbon::parse($loan->due_date);
            
            // Calculate Duration (Day to Day)
            $start = \Carbon\Carbon::parse($loan->borrow_date)->startOfDay();
            $end = $returnDate->copy()->startOfDay();
            $duration = $start->diffInDays($end);
            if($duration == 0 && $start->isSameDay($end)) $duration = 1;
            
            $fine = 0;
            $daysLate = 0;

            if ($returnDate->gt($dueDate)) {
                $daysLate = $returnDate->copy()->startOfDay()->diffInDays($dueDate->startOfDay()->addDay()); // Late if past due
                 if($returnDate->gt($dueDate)) {
                     $daysLate = $returnDate->diffInDays($dueDate);
                     $fine = $daysLate * 500;
                 }
            }
             // Simplified Late Check
             if ($end->gt($dueDate->startOfDay())) {
                 $daysLate = $end->diffInDays($dueDate->startOfDay());
                 $fine = $daysLate * 500;
             }

            return response()->json([
                'status' => 'success',
                'data' => [
                    'title' => $book->title,
                    'barcode' => $book->barcode,
                    'loan_date' => $start->format('d-m-Y'),
                    'duration' => $duration . ' Hari',
                    'late_days' => $daysLate,
                    'fine' => $fine,
                    'formatted_fine' => 'Rp ' . number_format($fine, 0, ',', '.')
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Server Error: ' . $e->getMessage()], 500);
        }
    }

    public function storeReturn(Request $request)
    {
        try {
        $memberId = session('santri_id');
        if (!$memberId) return response()->json(['status' => 'error', 'message' => 'Sesi habis.'], 401);

        $bookCode = trim($request->input('book_code'));

        if (!$bookCode) return response()->json(['status' => 'error', 'message' => 'Kode buku wajib diisi.'], 400);

        // 1. Find Book
        $book = \App\Models\Book::where('id', $bookCode)
                    ->orWhere('barcode', $bookCode)
                    ->first();

        if (!$book) return response()->json(['status' => 'error', 'message' => 'Buku tidak ditemukan.'], 404);

        // 2. Find Active Loan
        $loan = \App\Models\Loan::where('member_id', $memberId)
                    ->where('book_id', $book->id)
                    ->where('status', 'active')
                    ->first();

        if (!$loan) {
            return response()->json(['status' => 'error', 'message' => 'Anda tidak sedang meminjam buku ini.'], 400);
        }

        // 3. Process Return
        $returnDate = now();
        $dueDate = \Carbon\Carbon::parse($loan->due_date);
        
        $start = \Carbon\Carbon::parse($loan->borrow_date)->startOfDay();
        $end = $returnDate->copy()->startOfDay();
        $duration = $start->diffInDays($end);
        if($duration < 1) $duration = 1;

        $fine = 0;
        $daysLate = 0;

        if ($end->gt($dueDate->startOfDay())) {
             $daysLate = $end->diffInDays($dueDate->startOfDay());
             $fine = $daysLate * 500;
        }

        $note = "Dikembalikan. Durasi: $duration Hari.";
        if($fine > 0) $note .= " Denda: Rp" . $fine;

        $loan->update([
            'return_date' => $returnDate,
            'status' => 'returned',
            'notes' => $note
        ]);

        // 4. Update Stock
        $book->increment('stock');
        
        // Log Return History in Attendance/Visitor or just standard log
        
        $msg = "Pengembalian berhasil.<br>Buku: {$book->title}<br>Durasi: {$duration} Hari";
        if ($fine > 0) {
            $msg .= "<br><span class='text-red-600 font-bold'>Terlambat: {$daysLate} Hari (Denda Rp " . number_format($fine, 0, ',', '.') . ")</span>";
        } else {
             $msg .= "<br><span class='text-green-600 font-bold'>Tepat Waktu (Tidak ada denda)</span>";
        }

        return response()->json(['status' => 'success', 'message' => $msg]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Return Error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Gagal memproses: ' . $e->getMessage()], 500);
        }
    }

    public function storeSbp(Request $request)
    {
        $memberId = session('santri_id');
        if (!$memberId) return response()->json(['status' => 'error', 'message' => 'Sesi habis.'], 401);

        // 1. Check for Active Loans
        $activeLoansCount = \App\Models\Loan::where('member_id', $memberId)
                            ->where('status', 'active')
                            ->count();

        if ($activeLoansCount > 0) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Pengajuan SBP Ditolak. Anda masih memiliki ' . $activeLoansCount . ' buku yang belum dikembalikan.'
            ], 400);
        }

        // 2. Check for Existing Pending Request
        $existingRequest = \App\Models\SbpRequest::where('member_id', $memberId)
                            ->where('status', 'pending')
                            ->exists();

        if ($existingRequest) {
            return response()->json(['status' => 'error', 'message' => 'Anda sudah memiliki pengajuan SBP yang sedang diproses.'], 400);
        }

        // 3. Create Request
        \App\Models\SbpRequest::create([
            'member_id' => $memberId,
            'request_date' => now(),
            'status' => 'pending'
        ]);

        return response()->json(['status' => 'success', 'message' => 'Pengajuan SBP berhasil dikirim. Silakan tunggu konfirmasi Admin.']);
    }
}
