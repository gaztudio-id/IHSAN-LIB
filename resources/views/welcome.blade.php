<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - IHSAN-LIB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 h-screen flex flex-col items-center justify-center p-4">

    <div class="text-center mb-10 w-full max-w-2xl">
        <div class="flex justify-center mb-6">
            <img src="{{ asset('logo_ibs.png') }}" alt="Logo IBS" class="h-20 w-auto mb-4 object-contain filter drop-shadow-md hover:scale-105 transition-transform duration-300">
        </div>
        <h1 class="text-5xl font-extrabold text-green-700 tracking-tight mb-3">IHSAN-LIB</h1>
        <p class="text-gray-500 text-xl font-medium">Sistem Informasi Perpustakaan Digital</p>
        <p class="text-gray-400 text-sm mt-1">Al-Ihsan Boarding School Riau</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full max-w-5xl">
        
        <!-- Button 1: Landing Page -->
        <a href="{{ route('landing') }}" class="group relative flex flex-col items-center p-8 bg-white rounded-2xl shadow-lg border border-gray-100 hover:border-green-300 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="p-5 rounded-full bg-blue-50 group-hover:bg-blue-100 transition-colors mb-6">
                <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2 group-hover:text-blue-700">Landing Page</h3>
            <p class="text-sm text-gray-500 text-center leading-relaxed">Informasi profil perpustakaan dan layanan umum.</p>
        </a>

        <!-- Button 2: Portal Santri -->
        <a href="{{ route('portal.index') }}" class="group relative flex flex-col items-center p-8 bg-white rounded-2xl shadow-lg border-2 border-green-100 hover:border-green-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 ring-1 ring-green-50">
            <div class="absolute top-0 right-0 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-bl-lg rounded-tr-lg">UTAMA</div>
            <div class="p-5 rounded-full bg-green-50 group-hover:bg-green-100 transition-colors mb-6">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2 group-hover:text-green-700">Area Santri</h3>
            <p class="text-sm text-gray-500 text-center leading-relaxed">Portal khusus santri untuk login dan peminjaman.</p>
        </a>

        <!-- Button 3: Staff/Admin -->
        <!-- Button 3: Staff/Admin (With Gate) -->
        <button onclick="openStaffModal()" class="group relative flex flex-col items-center p-8 bg-white rounded-2xl shadow-lg border border-gray-100 hover:border-purple-300 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 w-full text-left">
            <div class="p-5 rounded-full bg-purple-50 group-hover:bg-purple-100 transition-colors mb-6">
                <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2 group-hover:text-purple-700">Staff & Admin</h3>
            <p class="text-sm text-gray-500 text-center leading-relaxed">Akses manajemen sistem untuk petugas.</p>
        </button>

    </div>

    <footer class="absolute bottom-6 text-gray-400 text-sm font-medium">
        &copy; {{ date('Y') }} Al-Ihsan Boarding School Riau. All rights reserved.
    </footer>

    <!-- STAFF GATE MODAL -->
    <div id="staff-gate-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-60 hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white w-full max-w-sm p-8 rounded-2xl shadow-2xl transform scale-95 transition-transform duration-300 relative">
            <button onclick="closeStaffModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="text-center">
                <h3 class="text-xl font-bold text-gray-800 mb-1">Verifikasi Petugas</h3>
                <p class="text-sm text-gray-500 mb-6">Scan kartu identitas untuk melanjutkan.</p>

                <!-- Status Notification -->
                <div id="staff-gate-error" class="hidden mb-4 p-3 bg-red-50 text-red-600 text-sm rounded-lg border border-red-100 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span id="staff-error-text">Kartu tidak dikenali.</span>
                </div>

                <!-- Green Fingerprint Button -->
                <button id="activate-staff-scan" class="group relative w-32 h-32 mx-auto bg-purple-50 rounded-full flex items-center justify-center mb-6 transition-all duration-300 hover:bg-purple-100 focus:outline-none">
                     <div id="staff-pulse" class="absolute inset-0 bg-purple-400 rounded-full opacity-0 transition-opacity duration-300"></div>
                    <svg class="w-16 h-16 text-purple-600 group-hover:text-purple-700 transition-colors z-10" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                    </svg>
                </button>
                <p id="staff-instruction" class="text-gray-500 text-sm mb-6">Klik ikon untuk <span class="font-bold text-purple-600">SCAN KARTU</span></p>

                <!-- Hidden Input -->
                <input type="text" id="staff-rfid-input" class="opacity-0 absolute top-0 left-0 w-full h-full -z-10" autocomplete="off">
                
                <!-- Manual Toggle -->
                <button onclick="document.getElementById('form-staff-manual').classList.toggle('hidden'); document.getElementById('staff-manual-code').focus();" class="text-xs text-purple-600 hover:text-purple-800 underline">
                    Input Kode Manual
                </button>
                
                <form id="form-staff-manual" class="hidden mt-4 pt-4 border-t border-gray-100 flex gap-2">
                    <input type="text" id="staff-manual-code" class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500" placeholder="Kode ID...">
                    <button type="submit" class="px-3 py-2 bg-purple-600 text-white text-sm font-bold rounded-lg hover:bg-purple-700">OK</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('staff-gate-modal');
        const input = document.getElementById('staff-rfid-input');
        const errorBox = document.getElementById('staff-gate-error');
        const errorText = document.getElementById('staff-error-text');
        
        function openStaffModal() {
            modal.classList.remove('hidden');
            setTimeout(() => modal.classList.remove('opacity-0'), 10);
            input.focus();
        }

        function closeStaffModal() {
            modal.classList.add('opacity-0');
            setTimeout(() => modal.classList.add('hidden'), 300);
            errorBox.classList.add('hidden');
        }

        function verifyStaff(code) {
            errorBox.classList.add('hidden');
            fetch('{{ route('staff.verify') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ rfid_code: code })
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    // Success! Redirect to Login with Email
                    window.location.href = data.redirect + '?email=' + encodeURIComponent(data.email);
                } else {
                    errorText.innerText = data.message || 'Akses Ditolak.';
                    errorBox.classList.remove('hidden');
                    input.value = '';
                    input.focus();
                }
            })
            .catch(e => {
                console.error(e);
                errorText.innerText = 'Gagal terhubung ke server.';
                errorBox.classList.remove('hidden');
            });
        }

        // Activate Scanner Logic
        document.getElementById('activate-staff-scan').addEventListener('click', () => {
            input.focus();
            document.getElementById('staff-pulse').classList.add('animate-ping', 'opacity-30');
            document.getElementById('staff-instruction').innerHTML = '<span class="text-purple-600 font-bold animate-pulse">TEMPEL KARTU...</span>';
            setTimeout(() => {
                document.getElementById('staff-pulse').classList.remove('animate-ping', 'opacity-30');
                document.getElementById('staff-instruction').innerHTML = 'Klik ikon untuk <span class="font-bold text-purple-600">SCAN KARTU</span>';
            }, 5000);
            // Aggressive Focus for 5s
            const interval = setInterval(() => input.focus(), 100);
            setTimeout(() => clearInterval(interval), 5000);
        });

        // Listen for standard Scanner Input (Enter key or fast typing)
        let buffer = '';
        let lastKeyTime = Date.now();
        
        // Simple Input Listener
        input.addEventListener('keydown', (e) => {
            if(e.key === 'Enter') {
                if(input.value.trim().length > 0) verifyStaff(input.value.trim());
            }
        });

        // Manual Form
        document.getElementById('form-staff-manual').addEventListener('submit', (e) => {
            e.preventDefault();
            const code = document.getElementById('staff-manual-code').value;
            if(code) verifyStaff(code);
        });
    </script>
</body>
</html>
