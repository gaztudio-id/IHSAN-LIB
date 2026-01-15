@extends('layouts.admin')

@section('header', 'Laporan Bulanan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    
    <!-- Filter Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8">
        <div class="flex items-center gap-3 mb-6">
            <div class="bg-green-100 p-2 rounded-lg text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-800">Laporan Aktivitas Bulanan</h3>
                <p class="text-sm text-gray-500">Pilih periode untuk melihat atau mencetak laporan.</p>
            </div>
        </div>
        
        <form action="{{ route('admin.reports.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="month" class="block text-sm font-semibold text-gray-700 mb-2">Bulan</label>
                    <div class="relative">
                        <select id="month" name="month" class="block w-full pl-4 pr-10 py-2.5 text-base border-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-lg bg-gray-50 transition-shadow">
                            @php
                                $months = [
                                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                ];
                            @endphp
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ (request('month') ?? date('n')) == $m ? 'selected' : '' }}>
                                    {{ $months[$m] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label for="year" class="block text-sm font-semibold text-gray-700 mb-2">Tahun</label>
                    <div class="relative">
                        <select id="year" name="year" class="block w-full pl-4 pr-10 py-2.5 text-base border-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-lg bg-gray-50 transition-shadow">
                            @foreach(range(date('Y'), date('Y')-5) as $y)
                                <option value="{{ $y }}" {{ (request('year') ?? date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-gray-50 mt-4">
                <button type="submit" class="flex-1 flex items-center justify-center px-4 py-2.5 border border-green-600 shadow-sm text-sm font-medium rounded-lg text-green-700 bg-white hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    Tampilkan Preview
                </button>
                <a href="#" onclick="printReport(event)" class="flex-1 flex items-center justify-center px-4 py-2.5 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak PDF
                </a>
            </div>
        </form>
    </div>

    <!-- Preview Section -->
    @if(isset($previewData))
    <div id="report-preview" class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden animate-fade-in-up">
        <div class="bg-green-50 px-6 py-4 border-b border-green-100 flex justify-between items-center">
            <h4 class="font-bold text-green-800">Preview Laporan: {{ $previewData['monthName'] }} {{ $previewData['year'] }}</h4>
            <span class="text-xs font-mono text-green-600 bg-white px-2 py-1 rounded border border-green-200">Generated at {{ $previewData['generatedAt'] }}</span>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Stat Card 1 -->
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                    <div class="text-sm text-gray-500 mb-1">Anggota Baru</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $previewData['newMembers'] }}</div>
                </div>
                <!-- Stat Card 2 -->
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                    <div class="text-sm text-gray-500 mb-1">Buku Ditambahkan</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $previewData['newBooks'] }}</div>
                </div>
                <!-- Stat Card 3 -->
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                    <div class="text-sm text-gray-500 mb-1">Kunjungan</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $previewData['visitsCount'] }}</div>
                </div>
                 <!-- Stat Card 4 -->
                 <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                    <div class="text-sm text-gray-500 mb-1">Peminjaman</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $previewData['loansCount'] }}</div>
                </div>
                 <!-- Stat Card 5 -->
                 <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                    <div class="text-sm text-gray-500 mb-1">Pengembalian</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $previewData['returnsCount'] }}</div>
                </div>
                 <!-- Stat Card 6 -->
                 <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                    <div class="text-sm text-gray-500 mb-1">SBP Terbit</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $previewData['sbpIssued'] }}</div>
                </div>
            </div>

            <!-- Visual Layout resembles print -->
            <div class="mt-8 pt-8 border-t border-gray-100 text-center text-sm text-gray-400">
                <p>Dokumen ini adalah preview. Klik "Cetak PDF" untuk mengunduh versi resmi dengan kop surat dan tanda tangan.</p>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('report-preview').scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    </script>
    @endif

</div>

<script>
    function printReport(e) {
        e.preventDefault();
        const month = document.getElementById('month').value;
        const year = document.getElementById('year').value;
        const url = `{{ route('admin.reports.print') }}?month=${month}&year=${year}`;
        window.open(url, '_blank');
    }
</script>

<style>
    @keyframes fade-in-up {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fade-in-up 0.3s ease-out forwards;
    }
</style>
@endsection
