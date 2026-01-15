@extends('layouts.admin')

@section('header', 'Manajemen Anggota')

@section('content')
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-800">Daftar Anggota</h3>
        <a href="{{ route('admin.members.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm shadow-sm transition-colors">Tambah Anggota</a>
    </div>
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative m-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Filter Section -->
    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
        <form action="{{ route('admin.members.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Nama/NIS</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Contoh: Ahmad..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
            </div>

            <!-- Class Filter -->
            <div>
                <label for="class_name" class="block text-sm font-medium text-gray-700 mb-1">Filter Angkatan/Kelas</label>
                <select name="class_name" id="class_name" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                    <option value="">Semua Kelas</option>
                    @foreach($classList as $cls)
                        <option value="{{ $cls }}" {{ request('class_name') == $cls ? 'selected' : '' }}>{{ $cls }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Month Filter -->
            <div>
                <label for="month" class="block text-sm font-medium text-gray-700 mb-1">Bulan Daftar</label>
                <select name="month" id="month" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                    <option value="">Semua Bulan</option>
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 10)) }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Year Filter -->
            <div>
                <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Tahun Daftar</label>
                <select name="year" id="year" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                    <option value="">Semua Tahun</option>
                    @foreach(range(date('Y'), 2020) as $y)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Submit Button (Hidden on desktop, auto-submit via JS or user clicks Enter? Better add a button) -->
            <div class="md:col-span-4 flex justify-end">
                <a href="{{ route('admin.members.index') }}" class="mr-3 px-4 py-2 text-sm text-gray-600 hover:text-gray-900">Reset</a>
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm font-medium shadow-sm">Terapkan Filter</button>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIS</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Angkatan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">RFID</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($members as $member)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $member->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->nis }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->class_name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->rfid_code ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.members.edit', $member->id) }}" class="text-green-600 hover:text-green-900 mr-2 font-medium">Edit</a>
                        <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
