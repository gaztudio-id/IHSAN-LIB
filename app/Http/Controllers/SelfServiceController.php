<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SelfServiceController extends Controller
{
    public function index()
    {
        return view('self-service.register');
    }

    public function check(Request $request)
    {
        $code = $request->query('code');
        $member = \App\Models\Member::where('rfid_code', $code)->first();

        if ($member) {
            return response()->json(['exists' => true, 'member' => $member]);
        }
        return response()->json(['exists' => false]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'rfid_code' => 'required|unique:members',
            'name' => 'required|string|max:255',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'nis' => 'required|unique:members',
            'class_name' => 'required'
        ]);

        \App\Models\Member::create([
            'rfid_code' => $request->rfid_code,
            'name' => $request->name,
            'place_of_birth' => $request->place_of_birth,
            'date_of_birth' => $request->date_of_birth,
            'nis' => $request->nis,
            'class_name' => $request->class_name
        ]);

        return redirect()->route('self-service.index')->with('success', 'Pendaftaran Berhasil! Silakan tap kartu berikutnya.');
    }
}
