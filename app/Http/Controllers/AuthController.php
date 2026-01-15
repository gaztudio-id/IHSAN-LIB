<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        // 1. If already logged in, redirect to Dashboard
        if (Auth::check()) {
             return Auth::user()->role === 'super_admin' ? redirect()->intended('/admin') : redirect()->intended('/staff');
        }

        // 2. SECURITY GATE: Require 'staff_access_granted' flash session
        if (!session('staff_access_granted')) {
             return redirect()->route('landing')->with('error', 'Akses Ditolak. Silakan verifikasi kartu identitas terlebih dahulu.');
        }
        
        // 3. Keep the flash session alive for this request (so form submission works)
        session()->reflash();

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Clear the gate token after successful login
            // session()->forget('staff_access_granted'); // It's flash, dies anyway.

            if (Auth::user()->role === 'super_admin') {
                return redirect()->intended('/admin');
            } else {
                return redirect()->intended('/staff');
            }
        }

        // RE-GRANT ACCESS on Login Failure so they aren't kicked out
        session()->flash('staff_access_granted', true);

        return back()->with('error', 'Login gagal! Password salah atau akun tidak ditemukan.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/landing');
    }
    
    public function verifyRfid(Request $request)
    {
        try {
            $code = trim($request->input('rfid_code'));
            if (!$code) return response()->json(['status' => 'error', 'message' => 'Kode wajib diisi.'], 400);

            $user = \App\Models\User::where('rfid_code', $code)->first();

            if ($user) {
                // GRANT ACCESS (ONE TIME PASS)
                session()->flash('staff_access_granted', true);

                return response()->json([
                    'status' => 'success', 
                    'email' => $user->email, 
                    'redirect' => route('login') 
                ]);
            }

            return response()->json(['status' => 'error', 'message' => 'Data Staff/Admin tidak ditemukan.'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Server Error: ' . $e->getMessage()], 500);
        }
    }
}
