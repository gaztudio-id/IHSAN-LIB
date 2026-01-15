@extends('layouts.admin')

@section('content')
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Anggota -->
        <!-- Total Anggota -->
        <a href="{{ route('admin.members.index') }}" class="bg-white rounded-xl shadow-sm p-6 flex items-center hover:shadow-md transition cursor-pointer">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Anggota</p>
                <p class="text-2xl font-bold text-gray-800">{{ $memberCount }}</p>
            </div>
        </a>

        <!-- Buku Tersedia -->
        <!-- Buku Tersedia -->
        <a href="{{ route('admin.books.index') }}" class="bg-white rounded-xl shadow-sm p-6 flex items-center hover:shadow-md transition cursor-pointer">
            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Judul Buku</p>
                <p class="text-2xl font-bold text-gray-800">{{ $bookCount }}</p>
            </div>
        </a>
        
        <!-- Peminjaman -->
        <div class="bg-white rounded-xl shadow-sm p-6 flex items-center">
             <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Sedang Dipinjam</p>
                <p class="text-2xl font-bold text-gray-800">{{ $loanCount }}</p>
            </div>
        </div>
        

    </div>

    <!-- Chart -->
    <div class="bg-white p-6 rounded-xl shadow-sm mb-8">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik Minggu Ini</h3>
        <div style="position: relative; height: 300px; width: 100%;">
            <canvas id="kunjunganChart"></canvas>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Aktivitas Peminjaman -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Peminjaman Terakhir
            </h3>
            <div class="space-y-4">
                @forelse($recentLoans as $loan)
                <div class="flex items-start border-b border-gray-50 pb-3 last:border-0 last:pb-0">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs">
                        {{ substr($loan->member->name ?? '?', 0, 1) }}
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-800">{{ $loan->member->name ?? 'Unknown' }}</p>
                        <p class="text-xs text-gray-500">Meminjam <span class="text-blue-600 font-medium">{{ $loan->book->title ?? 'Buku' }}</span></p>
                        <p class="text-[10px] text-gray-400 mt-0.5">{{ $loan->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-400 italic">Belum ada peminjaman.</p>
                @endforelse
            </div>
        </div>

        <!-- Aktivitas Kunjungan -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Kunjungan Terakhir
            </h3>
             <div class="space-y-4">
                @forelse($recentAttendances as $attendance)
                <div class="flex items-start border-b border-gray-50 pb-3 last:border-0 last:pb-0">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold text-xs">
                        {{ substr($attendance->member->name ?? '?', 0, 1) }}
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-800">{{ $attendance->member->name ?? 'Unknown' }}</p>
                        <p class="text-xs text-gray-500">Scan Kartu</p>
                        <p class="text-[10px] text-gray-400 mt-0.5">{{ \Carbon\Carbon::parse($attendance->scanned_at)->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                 <p class="text-sm text-gray-400 italic">Belum ada kunjungan hari ini.</p>
                @endforelse
            </div>
        </div>
    </div>

<script>
    const ctx = document.getElementById('kunjunganChart').getContext('2d');
    
    // Data from Controller
    const labels = @json($labels);
    const data = @json($data);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Kunjungan',
                data: data,
                borderColor: '#10b981', // green-500
                backgroundColor: 'rgba(16, 185, 129, 0.1)', // green-500 with opacity
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#10b981',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0
                    },
                    grid: {
                        color: '#f3f4f6'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#064e3b', // green-900
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: false
                }
            }
        }
    });
</script>
@endsection
