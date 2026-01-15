<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RfidController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SbpController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SelfServiceController;

// --- PUBLIC ROUTES (Kiosk & Portal) ---

// --- PUBLIC ROUTES ---

// Temporary Debug Route for Auth Fix
Route::get('/fix-auth', function () {
    try {
        \App\Models\User::truncate();
        
        $admin = \App\Models\User::create([
            'name' => 'Super Admin',
            'email' => 'admin@ihsan.lib',
            'password' => Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'super_admin'
        ]);

        $staff = \App\Models\User::create([
            'name' => 'Staff Perpustakaan',
            'email' => 'staff@ihsan.lib',
            'password' => Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'staff_perpus'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Users table wiped and re-seeded successfully.',
            'users' => [
                ['email' => $admin->email, 'role' => $admin->role, 'plain_password' => 'password'],
                ['email' => $staff->email, 'role' => $staff->role, 'plain_password' => 'password']
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
});

// Debug Route for Member Login
Route::get('/debug-member/{nis}', function ($nis) {
    try {
        $member = \App\Models\Member::where('nis', $nis)->orWhere('rfid_code', $nis)->first();
        if ($member) {
            return response()->json(['status' => 'found', 'member' => $member]);
        }
        return response()->json(['status' => 'not_found', 'input' => $nis]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
});

Route::get('/debug-schema', function() {
    return response()->json([
        'attendances' => \Illuminate\Support\Facades\Schema::getColumnListing('attendances')
    ]);
});

// Cover / Home
Route::get('/', function () {
    return view('welcome');
});

// Landing Page
Route::get('/landing', function () {
    $books = \App\Models\Book::latest()->take(10)->get();
    return view('landing', compact('books'));
})->name('landing');



// Self-Service Registration
Route::get('/self-register', [SelfServiceController::class, 'index'])->name('self-service.index');
Route::get('/self-register/check', [SelfServiceController::class, 'check'])->name('self-service.check');
Route::post('/self-register/store', [SelfServiceController::class, 'store'])->name('self-service.store');

// Portal Anggota (Login via NIS handled in JS/Controller)
Route::get('/portal', [PortalController::class, 'index'])->name('portal.index');
Route::post('/portal/login', [App\Http\Controllers\PortalController::class, 'login'])->name('portal.login');
Route::post('/portal/logout', [App\Http\Controllers\PortalController::class, 'logout'])->name('portal.logout');
Route::post('/portal/attendance', [App\Http\Controllers\PortalController::class, 'storeAttendance'])->name('portal.attendance.store');
Route::post('/portal/loan', [App\Http\Controllers\PortalController::class, 'storeLoan'])->name('portal.loan.store');
Route::post('/portal/loan/check', [App\Http\Controllers\PortalController::class, 'checkBook'])->name('portal.loan.check');
Route::post('/portal/return', [App\Http\Controllers\PortalController::class, 'storeReturn'])->name('portal.return.store');
Route::post('/portal/return/check', [App\Http\Controllers\PortalController::class, 'checkReturn'])->name('portal.return.check');
Route::post('/portal/sbp', [App\Http\Controllers\PortalController::class, 'storeSbp'])->name('portal.sbp.store');
Route::get('/portal/search', [App\Http\Controllers\PortalController::class, 'search'])->name('portal.search');


// --- AUTH ROUTES (Staff & Admin) ---
Route::post('/verify-staff-rfid', [AuthController::class, 'verifyRfid'])->name('staff.verify');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- PROTECTED ROUTES ---

Route::middleware(['auth'])->group(function () {

    // SHARED ROUTES (Admin & Staff)
    Route::middleware(['auth'])->name('admin.')->group(function () {
        // Shared Resources
        Route::resource('members', MemberController::class);
        Route::resource('books', BookController::class);
        
        // SBP Routes (Shared)
        Route::get('sbp', [SbpController::class, 'index'])->name('sbp.index');
        Route::patch('sbp/{id}', [SbpController::class, 'update'])->name('sbp.update');
        Route::get('sbp/{id}/print', [SbpController::class, 'print'])->name('sbp.print');

        // Report Routes (Shared)
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/print', [ReportController::class, 'print'])->name('reports.print');
    });

    // ADMIN ONLY ROUTES
    Route::middleware(['role:super_admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::resource('users', UserController::class);
    });

    // STAFF ROUTES
    Route::middleware(['role:staff_perpus'])->prefix('staff')->name('staff.')->group(function () {
        Route::get('/', [StaffController::class, 'index'])->name('index');
    });
});
