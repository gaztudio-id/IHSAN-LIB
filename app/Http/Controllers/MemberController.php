<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::query();

        // 1. Search (Name/NIS)
        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function($q) use ($term) {
                $q->where('name', 'like', '%' . $term . '%')
                  ->orWhere('nis', 'like', '%' . $term . '%');
            });
        }

        // 2. Filter by Class (Angkatan/Kelas)
        if ($request->filled('class_name')) {
            $query->where('class_name', $request->class_name);
        }

        // 3. Filter by Registration Date
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        // Execute with Pagination
        $members = $query->latest()->paginate(10)->withQueryString();

        // Data for Filter Dropdowns
        $classList = Member::whereNotNull('class_name')->distinct()->orderBy('class_name')->pluck('class_name');
        
        return view('admin.members.index', compact('members', 'classList'));
    }

    public function create()
    {
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'place_of_birth' => 'required',
            'date_of_birth' => 'required|date',
            'nis' => 'required|unique:members',
            'class_name' => 'required',
            'rfid_code' => 'unique:members|nullable'
        ]);

        Member::create($request->all());

        return redirect()->route('admin.members.index')->with('success', 'Member created successfully.');
    }

    public function edit(Member $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required',
            'nis' => 'required|unique:members,nis,'.$member->id,
            'class_name' => 'required'
        ]);

        $member->update($request->all());

        return redirect()->route('admin.members.index')->with('success', 'Member updated successfully.');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('admin.members.index')->with('success', 'Member deleted successfully.');
    }
}
