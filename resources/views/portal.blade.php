<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IHSAN-LIB - Portal Anggota</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .page-view { display: none; }
        .page-view.active { display: block; }
        .swiper-container { width: 100%; padding-bottom: 50px; }
        .swiper-slide { width: 200px; height: 300px; background-color: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: transform 0.3s ease; }
        .swiper-slide:hover { transform: translateY(-5px); }
        .swiper-pagination-bullet-active { background-color: #3b82f6; }
        .swiper-button-next, .swiper-button-prev { color: #3b82f6; transform: scale(0.8); }
        .swiper-button-next:after, .swiper-button-prev:after { font-size: 32px !important; font-weight: 800; }
        .modal-overlay { transition: opacity 0.3s ease-in-out; }
        .modal-content { transition: transform 0.3s ease-in-out; }
        @keyframes fadeOut { from { opacity: 1; transform: translateY(0); } to { opacity: 0; transform: translateY(-20px); } }
        .fade-out-notif { animation: fadeOut 0.5s ease-out 2.5s forwards; }
        .service-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .service-card:hover { transform: translateY(-8px); box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</head>
<body class="antialiased text-gray-800">

    <header class="bg-white/90 backdrop-blur-md shadow-sm sticky top-0 z-40 border-b border-gray-200">
        <nav class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Left: Logo & Back -->
                <div class="flex-shrink-0 flex items-center gap-3">
                    @if(!$member)
                        <a href="{{ url('/') }}" class="p-2 mr-2 text-gray-400 hover:text-green-700 hover:bg-green-50 rounded-full transition-colors" title="Kembali ke Cover">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        </a>
                    @endif
                    <img src="{{ asset('logo_ibs.png') }}" alt="Logo IBS" class="h-10 w-auto">
                    <span class="text-xl font-bold text-green-700 tracking-tight">Ihsan-Lib <span class="text-gray-400 font-light">|</span> Santri</span>
                </div>
                <!-- Desktop Nav (Simplified) -->
                <div class="hidden sm:flex sm:items-center sm:space-x-4" id="nav-links">
                     <!-- Only functional links -->
                    <button data-action="show-view" data-view="main-landing-page" class="text-gray-600 hover:text-blue-600 font-medium px-3 py-2 rounded-md transition-colors">Dashboard</button>
                    <button data-action="show-view" data-view="katalog-page" class="text-gray-600 hover:text-blue-600 font-medium px-3 py-2 rounded-md transition-colors">Cari Buku</button>
                    <a href="http://opac.ibs.sch.id" target="_blank" class="text-gray-600 hover:text-blue-600 font-medium px-3 py-2 rounded-md transition-colors">OPAC Eksternal</a>
                    
                    <div class="w-px h-6 bg-gray-300 mx-2"></div>
                    
                    <div class="flex items-center text-green-700 font-semibold px-3 py-2 rounded-md transition-colors gap-2">
                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 shadow-sm border border-green-200">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </div>
                        <span id="nav-user-name">Santri</span>
                    </div>
                    <button data-action="logout" class="text-gray-500 hover:text-red-600 font-medium px-3 py-2 rounded-md transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                    </button>
                </div>
                <div class="flex items-center sm:hidden">
                    <button id="mobile-menu-button" class="text-gray-600 hover:text-blue-600 focus:outline-none">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path id="icon-open" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                            <path id="icon-close" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            </div>
            <div id="mobile-menu" class="sm:hidden hidden">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <button data-action="show-view" data-view="main-landing-page" class="mobile-nav-link block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50">Beranda</button>
                    <button data-action="show-view" data-view="katalog-page" class="mobile-nav-link block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50">Katalog Internal</button>
                    <a href="http://opac.ibs.sch.id" target="_blank" class="mobile-nav-link block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50">OPAC Eksternal</a>
                    <button data-action="open-modal" data-modal="absen-modal" class="mobile-nav-link block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50">Absen Kunjungan</button>
                    <button data-action="open-modal" data-modal="sbp-modal" class="mobile-nav-link block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50">Bebas Pustaka</button>
                    <div class="border-t border-gray-200 my-2"></div>
                    <button id="profile-nav-mobile" data-action="show-profile" class="mobile-nav-link block w-full text-left px-3 py-2 rounded-md text-base font-semibold text-blue-600 hover:bg-blue-50">Profil</button>
                    <button id="logout-button-mobile" data-action="logout" class="{{ $member ? '' : 'hidden' }} mobile-nav-link block w-full text-left px-3 py-2 rounded-md text-base font-medium text-red-600 hover:bg-red-50">Logout</button>
                </div>
            </div>
        </nav>
    </header>

    <main id="main-landing-page" class="page-view {{ $member ? 'active' : '' }} container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Dashboard Welcome -->
        <div class="bg-green-600 rounded-2xl shadow-lg p-6 mb-8 text-white relative overflow-hidden">
             <div class="relative z-10">
                <h1 class="text-3xl font-bold">Ahlan Wa Sahlan, <span id="dash-user-name">{{ $member ? $member->name : 'Santri' }}</span>!</h1>
                <p class="mt-2 text-green-100">Selamat datang di Portal Perpustakaan Digital.</p>
                
                <div id="member-info-banner" class="mt-4 flex flex-wrap gap-4 text-sm bg-green-700/30 p-3 rounded-lg w-fit backdrop-blur-sm border border-green-500/30 {{ $member ? '' : 'hidden' }}">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .884-.5 2-2 2h4c-1.5 0-2-1.116-2-2z"/></svg> 
                        <span>NIS: <span id="banner-nis" class="font-mono font-bold text-white">{{ $member->nis ?? '-' }}</span></span>
                    </div>
                    <div class="w-px h-4 bg-green-400/50"></div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg> 
                        <span>Kelas: <span id="banner-class" class="font-bold text-white">{{ $member->class_name ?? '-' }}</span></span>
                    </div>
                    <div class="w-px h-4 bg-green-400/50"></div>
                     <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 
                        <span>Angkatan: <span id="banner-angkatan" class="font-bold text-white">{{ $member->angkatan ?? '-' }}</span></span>
                    </div>
                </div>

                <!-- ... (rest of banner) ... -->
            </div>
            <!-- ... (rest of banner) ... -->
        </div>

        <!-- ... -->

    <!-- Absen Modal Updates -->
    <div id="absen-modal" class="modal-overlay fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50 hidden" data-modal="absen-modal">
        <div class="modal-content bg-white w-full max-w-sm p-8 rounded-2xl shadow-2xl transform scale-100 relative">
            <button data-action="close-modal" data-modal="absen-modal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <div class="text-center">
                <h3 class="text-xl font-bold text-gray-800 mb-6 font-heading">Absensi Kunjungan</h3>
                
                <div id="absen-notification" class="p-3 mb-4 rounded-lg text-sm hidden font-medium transition-all duration-300"></div>

                <!-- Green Fingerprint Button (Now Activates Scanner) -->
                <button id="activate-scan-btn" class="group relative w-32 h-32 mx-auto bg-green-50 rounded-full flex items-center justify-center mb-6 transition-all duration-300 hover:bg-green-100 hover:scale-105 active:scale-95 focus:outline-none focus:ring-4 focus:ring-green-200">
                    <div id="scan-pulse" class="absolute inset-0 bg-green-400 rounded-full opacity-0 transition-opacity duration-300"></div>
                    <!-- Fingerprint Icon -->
                    <svg class="w-16 h-16 text-green-600 group-hover:text-green-700 transition-colors z-10" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.2-2.848.578-4.137m.087-2.67C5.32 2.68 7.352 1.5 10 1.5c2.648 0 4.68 1.18 5.335 2.687"></path>
                    </svg>
                </button>
                
                <p id="scan-instruction" class="text-gray-500 text-sm mb-6">Klik ikon di atas untuk <span class="font-bold text-green-600">MENGAKTIFKAN SCANNER</span></p>

                <!-- Manual Input Option -->
                <div class="mt-4 border-t pt-4">
                    <p class="text-xs text-gray-400 mb-2">Atau masukkan Nomor Induk / Kode secara manual:</p>
                    <form id="form-absen-manual" class="flex gap-2" onsubmit="event.preventDefault(); handleAbsenManualSubmit();">
                         <input type="text" id="manual-absen-input" class="flex-1 px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="NIS / RFID...">
                         <button type="submit" class="px-4 py-2 bg-green-600 text-white text-sm font-bold rounded-md hover:bg-green-700">OK</button>
                    </form>
                </div>

                <!-- Hidden Input for RFID Focus -->
                <input type="text" id="active-rfid-input" class="opacity-0 absolute top-0 left-0 h-full w-full -z-10" autocomplete="off">
<!-- ... (Rest of modal same) ... -->

<!-- JS Update for Logic -->
<script>
    // ... (Previous JS) ...

    // Activate Scanner Logic
    const activateScanner = (context) => {
        let inputId, pulseId, instructionId;
        
        if (context === 'absen') {
             inputId = 'active-rfid-input'; pulseId = 'scan-pulse'; instructionId = 'scan-instruction';
        } else if (context === 'login') {
             inputId = 'rfid-login-input'; pulseId = 'login-pulse'; instructionId = 'login-instruction';
        } else if (context === 'loan') {
             inputId = 'loan-rfid-input'; pulseId = 'loan-pulse'; instructionId = 'loan-instruction';
        }

        const input = document.getElementById(inputId);
        const pulse = document.getElementById(pulseId);
        const instruction = document.getElementById(instructionId);
        
        if(input) {
             input.focus();
             if(pulse) {
                 pulse.classList.add('animate-ping', 'opacity-20');
                 setTimeout(() => { pulse.classList.remove('animate-ping', 'opacity-20'); }, 5000); // 5s Timeout
             }
             if(instruction) {
                 const originalText = instruction.innerHTML;
                 instruction.innerHTML = '<span class="text-green-600 font-bold animate-pulse">SILAKAN TAP KARTU ANDA...</span>';
                 setTimeout(() => { instruction.innerHTML = originalText; }, 5000);
             }
             // REMOVED AGGRESSIVE FOCUS LOOP to prevent stealing focus from manual input
        }
    };

    // Update Click Listener
    const scanBtn = document.getElementById('activate-scan-btn');
    if(scanBtn) {
        scanBtn.addEventListener('click', () => {
            activateScanner('absen');
        });
    }

    // Update handleLoginSuccess to fill Banner
    const handleLoginSuccess = (data) => {
        try {
            isLoggedIn = true;
            
            // CRITICAL FIX: Remove the Brute Force Inline Style so the modal can be hidden
            // CRITICAL FIX: Remove the Brute Force Inline Style so the modal can be hidden
            const loginModal = document.getElementById('login-modal');
            if(loginModal) {
                loginModal.style.display = 'none'; // Direct style override
                loginModal.style.opacity = '0';
                loginModal.removeAttribute('style'); // Then clear it
                loginModal.classList.add('hidden'); // Ensure class hidden is added
                loginModal.setAttribute('aria-hidden', 'true');
            }

            showView('main-landing-page'); 
            
            // Fill Banner Safely
            const banner = document.getElementById('member-info-banner');
            if(banner) {
                banner.classList.remove('hidden');
                const elNis = document.getElementById('banner-nis'); if(elNis) elNis.innerText = data.data.nis || '-';
                const elClass = document.getElementById('banner-class'); if(elClass) elClass.innerText = data.data.class || '-';
                const elAngkatan = document.getElementById('banner-angkatan'); if(elAngkatan) elAngkatan.innerText = data.data.angkatan || '-';
            }

            // Update Names Safely
            const elNavName = document.getElementById('nav-user-name'); if(elNavName) elNavName.innerText = data.data.name;
            const elDashName = document.getElementById('dash-user-name'); if(elDashName) elDashName.innerText = data.data.name;
            
            // Update Logout Button Safely
            const logoutButton = document.getElementById('logout-button');
            if(logoutButton) logoutButton.classList.remove('hidden');
            const logoutButtonMobile = document.getElementById('logout-button-mobile');
            if(logoutButtonMobile) logoutButtonMobile.classList.remove('hidden');
            
            // Initial Data Load
            if(typeof loadProfileData === 'function') loadProfileData(data.data.nis);
            
            // Reset Login Form
            const errorMsg = document.getElementById('login-santri-error'); if(errorMsg) errorMsg.classList.add('hidden');
            const formLogin = document.getElementById('form-login-santri'); if(formLogin) formLogin.reset();
        
        } catch (e) {
            console.error("Login UI Update Error:", e);
            // Fallback: Reload page to sync server-side state if JS fails
            window.location.reload();
        }
    };

    // ...
</script>
            </div>
            <div class="absolute right-0 top-0 h-full w-1/3 opacity-10 bg-gradient-to-l from-white to-transparent transform skew-x-12"></div>
            <!-- Decorative Circle -->
            <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-green-500 rounded-full opacity-20 blur-2xl"></div>
        </div>
    </div> <!-- END ABSEN MODAL -->

        <!-- Dashboard Stats/Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
             <!-- Peminjaman Card -->
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-2 bg-yellow-50 text-yellow-600 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <span class="text-3xl font-bold text-gray-800">{{ count($activeLoans) }}</span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium">Buku Dipinjam</h3>
            </div>

             <!-- Kunjungan Card -->
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                     <div class="p-2 bg-green-50 text-green-600 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    </div>
                    <span class="text-3xl font-bold text-gray-800">{{ $totalAttendance ?? 0 }}</span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium">Total Kunjungan</h3>
            </div>

            <!-- Sirkulasi Action -->
            <button data-action="open-modal" data-modal="sirkulasi-menu-modal" class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition text-left group">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg group-hover:bg-indigo-600 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    </div>
                </div>
                 <h3 class="text-gray-800 font-semibold group-hover:text-indigo-700 font-medium">Sirkulasi</h3>
                <p class="text-xs text-gray-500 mt-1">Absensi, Peminjaman, Info</p>
            </button>

            <!-- Pengajuan Action -->
            <button data-action="open-modal" data-modal="sbp-form-modal" class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition text-left group">
                 <div class="flex justify-between items-start mb-4">
                    <div class="p-2 bg-teal-50 text-teal-600 rounded-lg group-hover:bg-teal-600 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                </div>
                 <h3 class="text-gray-800 font-semibold group-hover:text-teal-700 font-medium">Pengajuan</h3>
                <p class="text-xs text-gray-500 mt-1">Surat Bebas Pustaka</p>
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
             <!-- Active Loans -->
             <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                 <h3 class="text-lg font-bold text-gray-800 mb-4">Buku Sedang Dipinjam</h3>
                 <div class="space-y-4">
                    @forelse($activeLoans as $loan)
                     <div class="flex gap-4 p-3 rounded-lg hover:bg-gray-50 border border-gray-100">
                         <div class="w-12 h-16 bg-gray-200 rounded flex items-center justify-center text-xs text-gray-400">Cover</div>
                         <div>
                             <h4 class="font-semibold text-gray-800 text-sm">{{ $loan->book->title ?? 'Judul Tidak Ditemukan' }}</h4>
                             <p class="text-xs text-gray-500">Jatuh Tempo: <span class="font-bold {{ \Carbon\Carbon::parse($loan->due_date)->isPast() ? 'text-red-600' : 'text-green-600' }}">{{ $loan->due_date }}</span></p>
                         </div>
                     </div>
                    @empty
                        <p class="text-gray-500 text-sm text-center py-4">Tidak ada buku yang sedang dipinjam.</p>
                    @endforelse
                 </div>
             </div>

             <!-- Attendance History -->
             <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                 <h3 class="text-lg font-bold text-gray-800 mb-4">Riwayat Kunjungan</h3>
                 <ul class="space-y-3 max-h-68 overflow-y-auto">
                    @forelse($attendanceHistory as $history)
                        <li class="flex justify-between text-sm text-gray-600 border-b pb-2">
                             <span>{{ \Carbon\Carbon::parse($history->date)->translatedFormat('l, d M Y') }}</span>
                             <span class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">{{ \Carbon\Carbon::parse($history->time)->format('H:i') }}</span>
                        </li>
                    @empty
                        <li class="text-center text-gray-500 text-sm py-4">Belum ada riwayat kunjungan.</li>
                    @endforelse
                 </ul>
             </div>
        </div>

    </main>
    
    <main id="katalog-page" class="page-view container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Katalog Internal</h2>
            <button data-action="show-view" data-view="main-landing-page" class="text-sm text-blue-600 hover:underline">&larr; Kembali ke Beranda</button>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 mb-8">
            <form id="form-pencarian-internal" class="flex flex-col sm:flex-row gap-4" onsubmit="event.preventDefault(); handleSearchInternal();">
                <div class="flex-grow flex gap-2">
                    <div class="w-1/3 min-w-[140px]">
                         <select id="search-category-internal" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                            <option value="">Semua Kategori</option>
                            @if(isset($categories))
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}">{{ $cat }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <input type="text" id="search-query-internal" class="flex-grow w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Judul, Penulis, ISBN...">
                </div>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition-colors whitespace-nowrap">Cari Koleksi</button>
            </form>
        </div>
        <div id="hasil-pencarian-internal" class="space-y-4">
            <div id="pencarian-placeholder" class="text-center text-gray-500 py-12">
                <svg class="w-16 h-16 mx-auto text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                <p class="mt-4 text-lg">Silakan masukkan kata kunci untuk memulai pencarian.</p>
            </div>
        </div>
    </main>



    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row justify-between items-center text-center md:text-left">
                <p class="text-sm text-gray-600">&copy; 2025 IHSAN-LIB. Dibuat untuk Al-Ihsan Boarding School Riau.</p>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <button data-action="show-view" data-view="main-landing-page" class="text-sm text-gray-500 hover:text-blue-600">Beranda</button>
                    <button data-action="show-view" data-view="katalog-page" class="text-sm text-gray-500 hover:text-blue-600">Katalog</button>
                    <button data-action="open-modal" data-modal="absen-modal" class="text-sm text-gray-500 hover:text-blue-600">Absen</button>
                </div>
            </div>
        </div>
    </footer>


    <div id="absen-modal" class="modal-overlay fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50 hidden" data-modal="absen-modal">
        <div class="modal-content bg-white w-full max-w-sm p-8 rounded-2xl shadow-2xl transform scale-100 relative">
            <button data-action="close-modal" data-modal="absen-modal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <div class="text-center">
                <h3 class="text-xl font-bold text-gray-800 mb-6 font-heading">Absensi Kunjungan</h3>
                
                <div id="absen-notification" class="p-3 mb-4 rounded-lg text-sm hidden font-medium transition-all duration-300"></div>

                <!-- Green Fingerprint Button (Activates Scanner) -->
                <button id="activate-scan-btn" class="group relative w-32 h-32 mx-auto bg-green-50 rounded-full flex items-center justify-center mb-6 transition-all duration-300 hover:bg-green-100 hover:scale-105 active:scale-95 focus:outline-none focus:ring-4 focus:ring-green-200">
                     <div id="scan-pulse" class="absolute inset-0 bg-green-400 rounded-full opacity-0 transition-opacity duration-300"></div>
                    <!-- Fingerprint Icon -->
                    <svg class="w-16 h-16 text-green-600 group-hover:text-green-700 transition-colors z-10" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.2-2.848.578-4.137m.087-2.67C5.32 2.68 7.352 1.5 10 1.5c2.648 0 4.68 1.18 5.335 2.687"></path>
                    </svg>
                </button>
                
                <p id="scan-instruction" class="text-gray-500 text-sm mb-6">Klik ikon di atas untuk <span class="font-bold text-green-600">MENGAKTIFKAN SCANNER</span></p>

                <!-- Hidden Input for RFID Focus -->
                <input type="text" id="active-rfid-input" class="opacity-0 absolute top-0 left-0 h-full w-full -z-10" autocomplete="off">

                <!-- Manual Input Toggle -->
                <button onclick="document.getElementById('manual-absen-form').classList.toggle('hidden'); document.getElementById('manual-rfid-input').focus();" class="text-xs text-green-600 hover:text-green-800 font-medium underline decoration-green-300 underline-offset-2">
                    Input Manual (Jika Lupa Kartu)
                </button>

                <!-- Manual Form (Hidden by default) -->
                <form id="manual-absen-form" class="hidden mt-4 pt-4 border-t border-gray-100 animate-fade-in-down">
                    <div class="flex gap-2">
                        <input type="text" id="manual-rfid-input" class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none" placeholder="Masukkan NIS...">
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white text-sm font-bold rounded-lg hover:bg-green-700 transition">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SIRKULASI MENU MODAL -->
    <div id="sirkulasi-menu-modal" class="modal-overlay fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50 hidden" data-modal="sirkulasi-menu-modal">
        <div class="modal-content bg-white w-full max-w-lg p-6 rounded-2xl shadow-2xl transform scale-100 relative">
            <button data-action="close-modal" data-modal="sirkulasi-menu-modal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <h3 class="text-xl font-bold text-gray-800 mb-6 text-center font-heading">Menu Sirkulasi</h3>
            
            <div class="grid grid-cols-2 gap-4">
                <!-- 1. Absen Button -->
                <button onclick="closeModal('sirkulasi-menu-modal'); openModal('absen-modal');" class="flex flex-col items-center gap-3 p-4 rounded-xl bg-purple-50 hover:bg-purple-100 text-purple-700 transition group text-center h-full">
                    <div class="p-3 bg-white rounded-lg shadow-sm group-hover:shadow text-purple-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm">Absensi</h4>
                        <p class="text-xs opacity-75">Scan Masuk</p>
                    </div>
                </button>

                <!-- 2. Loan Button -->
                <button onclick="closeModal('sirkulasi-menu-modal'); openModal('loan-modal');" class="flex flex-col items-center gap-3 p-4 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 transition group text-center h-full">
                    <div class="p-3 bg-white rounded-lg shadow-sm group-hover:shadow text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                     <div>
                        <h4 class="font-bold text-sm">Peminjaman</h4>
                        <p class="text-xs opacity-75">Pinjam Mandiri</p>
                    </div>
                </button>

                <!-- 3. Return/Rules Button -->
                <!-- 3. Return Button (Functional) -->
                <button onclick="closeModal('sirkulasi-menu-modal'); openModal('return-modal');" class="flex flex-col items-center gap-3 p-4 rounded-xl bg-orange-50 hover:bg-orange-100 text-orange-700 transition group text-center h-full">
                    <div class="p-3 bg-white rounded-lg shadow-sm group-hover:shadow text-orange-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    </div>
                     <div>
                        <h4 class="font-bold text-sm">Pengembalian</h4>
                        <p class="text-xs opacity-75">Aturan & Sanksi</p>
                    </div>
                </button>

                <!-- 4. SOP/Rules Button -->
                <button onclick="closeModal('sirkulasi-menu-modal'); openModal('sop-modal');" class="flex flex-col items-center gap-3 p-4 rounded-xl bg-gray-50 hover:bg-gray-100 text-gray-700 transition group text-center h-full">
                    <div class="p-3 bg-white rounded-lg shadow-sm group-hover:shadow text-gray-600">
                         <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                     <div>
                        <h4 class="font-bold text-sm">SOP Sirkulasi</h4>
                        <p class="text-xs opacity-75">Tata Tertib</p>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- SOP MODAL (General Rules) -->
    <div id="sop-modal" class="modal-overlay fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50 hidden" data-modal="sop-modal">
        <div class="modal-content bg-white w-full max-w-sm p-8 rounded-2xl shadow-2xl transform scale-100 relative">
            <button data-action="close-modal" data-modal="sop-modal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <h3 class="text-xl font-bold text-gray-800 mb-4 font-heading text-center">Tata Tertib & SOP</h3>
            <ul class="space-y-3 text-sm text-gray-600 list-disc list-inside bg-gray-50 p-4 rounded-lg">
                <li>Wajib membawa <span class="font-bold">Kartu Anggota</span> saat berkunjung.</li>
                <li>Dilarang membawa <span class="font-bold">Tas & Jaket</span> ke area koleksi.</li>
                <li>Dilarang <span class="font-bold">Makan & Minum</span> di dalam perpustakaan.</li>
                <li>Menjaga <span class="font-bold">Ketenangan & Kebersihan</span>.</li>
                <li class="font-bold text-orange-600">Durasi Peminjaman Max 7 Hari.</li>
                <li class="font-bold text-red-600">Denda Keterlambatan Rp 500 / Hari per buku.</li>
            </ul>
             <div class="mt-4 text-center">
                <button onclick="closeModal('sop-modal')" class="text-sm text-indigo-600 hover:underline">Saya Mengerti</button>
            </div>
        </div>
    </div>


    <!-- RETURN MODAL (Functional 2-Step) -->
    <div id="return-modal" class="modal-overlay fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50 hidden" data-modal="return-modal">
        <div class="modal-content bg-white w-full max-w-sm p-8 rounded-2xl shadow-2xl transform scale-95 relative">
            <button data-action="close-modal" data-modal="return-modal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <div class="text-center">
                <h3 class="text-xl font-bold text-gray-800 mb-6 font-heading">Pengembalian Mandiri</h3>
                <div id="return-notification" class="p-3 mb-4 rounded-lg text-sm hidden font-medium transition-all duration-300"></div>

                <!-- CHECK SECTION (Step 1) -->
                <div id="return-check-section">
                    <p class="text-gray-500 text-sm mb-4">Masukkan Kode Buku untuk Cek Status:</p>
                    <form id="form-return-manual" class="flex flex-col gap-3" onsubmit="event.preventDefault(); handleReturnManualSubmit();">
                         <div class="relative">
                            <input type="text" id="return-code-input" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 font-mono text-center" placeholder="Scan/Input Kode..." autofocus>
                             <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                         </div>
                         <button type="submit" class="w-full py-2 bg-orange-600 text-white font-bold rounded-lg hover:bg-orange-700 shadow transition">CEK BUKU</button>
                    </form>
                </div>
                
                <!-- CONFIRM SECTION (Step 2 - Hidden by Default) -->
                <div id="return-confirm-section" class="hidden animate-fade-in-up">
                    <div class="text-left mb-4">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Konfirmasi Pengembalian</p>
                        <h4 id="return-confirm-title" class="text-lg font-bold text-gray-800 leading-tight">Judul Buku</h4>
                    </div>
                    
                    <div id="return-confirm-details" class="mb-6"></div>

                    <div class="flex gap-2">
                        <button onclick="cancelReturn()" class="flex-1 py-2 bg-gray-100 text-gray-700 font-bold rounded-lg hover:bg-gray-200 transition">Batal</button>
                        <button id="btn-confirm-return" class="flex-1 py-2 bg-orange-600 text-white font-bold rounded-lg hover:bg-orange-700 shadow transition">KEMBALIKAN</button>
                    </div>
                </div>

                <!-- Small Info Footer -->
                <div class="mt-6 bg-gray-50 rounded-lg p-3 text-xs text-left text-gray-500 border border-gray-100">
                    <p class="font-bold text-gray-700 mb-1">Ketentuan:</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Durasi pinjam max 7 hari.</li>
                        <li>Denda keterlambatan Rp 500/hari.</li>
                    </ul>
                </div>
                
                <input type="text" id="return-rfid-input" class="opacity-0 absolute top-0 left-0 h-full w-full -z-10" autocomplete="off">
            </div>
             <div class="absolute right-0 top-0 h-full w-1/3 opacity-10 bg-gradient-to-l from-white to-transparent transform skew-x-12"></div>
        </div>
    </div>

    <!-- SBP FORM MODAL -->
    <div id="sbp-form-modal" class="modal-overlay fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50 hidden" data-modal="sbp-form-modal">
        <div class="modal-content bg-white w-full max-w-sm p-8 rounded-2xl shadow-2xl transform scale-100 relative">
            <button data-action="close-modal" data-modal="sbp-form-modal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-teal-100 text-teal-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>

                <h3 class="text-xl font-bold text-gray-800 mb-2 font-heading">Pengajuan SBP</h3>
                <p class="text-sm text-gray-600 mb-6">Surat Bebas Pustaka diperlukan sebagai syarat kelulusan atau pindah sekolah.</p>

                <!-- DATA PUSTAKA SUMMARY (2 VERIFICATIONS) -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left border border-gray-100">
                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-3 border-b pb-2">Verifikasi Data Pustaka</h4>
                    
                    <div class="space-y-3">
                        <!-- Verification 1: Loans -->
                        <div class="flex items-center justify-between p-2 rounded {{ count($activeLoans) > 0 ? 'bg-red-100' : 'bg-green-100' }}">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full flex items-center justify-center {{ count($activeLoans) > 0 ? 'bg-red-500 text-white' : 'bg-green-500 text-white' }}">
                                    @if(count($activeLoans) > 0)
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    @endif
                                </div>
                                <span class="text-sm font-medium {{ count($activeLoans) > 0 ? 'text-red-800' : 'text-green-800' }}">
                                    @if(count($activeLoans) > 0)
                                        Masih ada {{ count($activeLoans) }} buku dipinjam
                                    @else
                                        Tidak ada peminjaman aktif
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Verification 2: Administration (Placeholder) -->
                        <div class="flex items-center justify-between p-2 rounded bg-green-100">
                             <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full flex items-center justify-center bg-green-500 text-white">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <span class="text-sm font-medium text-green-800">
                                    Denda / Administrasi Aman
                                </span>
                            </div>
                        </div>
                    </div>

                    @if(count($activeLoans) > 0)
                         <p class="text-xs text-red-600 mt-3 text-center">Mohon selesaikan tanggungan buku sebelum mengajukan SBP.</p>
                    @endif
                </div>
                
                <div id="sbp-error" class="p-3 mb-4 rounded-lg bg-red-50 text-red-700 text-sm hidden"></div>
                <div id="sbp-success" class="p-3 mb-4 rounded-lg bg-green-50 text-green-700 text-sm hidden"></div>

                @if(isset($calculatedGrade) && $calculatedGrade >= 12)
                    @if(isset($sbpRequest) && $sbpRequest->status == 'pending')
                         <div class="w-full py-3 bg-yellow-500 text-white font-bold rounded-lg shadow-sm text-center cursor-not-allowed">
                            MENUNGGU VERIFIKASI ADMIN
                        </div>
                        <p class="text-xs text-yellow-600 mt-2 text-center">Permohonan Anda sedang diperiksa oleh staff.</p>
                    @elseif(isset($sbpRequest) && $sbpRequest->status == 'approved')
                        <div class="w-full py-3 bg-green-500 text-white font-bold rounded-lg shadow-sm text-center cursor-not-allowed">
                            SBP TELAH DISETUJUI
                        </div>
                        <p class="text-xs text-green-600 mt-2 text-center">Silakan hubungi Tata Usaha untuk pengambilan surat.</p>
                    @else
                        <form onsubmit="event.preventDefault(); handleSbpRequest();">
                            <button type="submit" id="btn-submit-sbp" class="w-full py-3 bg-teal-600 text-white font-bold rounded-lg shadow-md hover:bg-teal-700 transition focus:outline-none focus:ring-4 focus:ring-teal-300">
                                AJUKAN SEKARANG
                            </button>
                            <div id="sbp-loading" class="hidden text-teal-600 mt-2 font-medium animate-pulse">Memproses...</div>
                        </form>
                    @endif
                @else
                     <div class="w-full py-3 bg-gray-200 text-gray-500 font-bold rounded-lg shadow-inner text-center cursor-not-allowed">
                        BELUM MEMENUHI SYARAT
                    </div>
                    <p class="text-xs text-red-500 mt-2 text-center">Pengajuan SBP hanya untuk Santri Kelas Akhir (Kelas 6/12).</p>
                    <p class="text-xs text-gray-500 mt-1 text-center">Silakan hubungi Admin jika data kelas Anda salah.</p>
                @endif

            </div>
        </div>
    </div>


<script>
    // ... (Existing Timer Code) ...

    // NEW FUNCTION: Activate Scanner
    const activateScanner = (inputId, pulseId, instrId) => {
        const input = document.getElementById(inputId);
        const pulse = document.getElementById(pulseId);
        const instr = document.getElementById(instrId);
        
        if(input) {
            input.focus();
            
            // Visual Feedback
            if(pulse) {
                pulse.classList.add('animate-ping', 'opacity-30');
                setTimeout(() => { pulse.classList.remove('animate-ping', 'opacity-30'); }, 5000);
            }
            if(instr) {
                const oldText = instr.innerHTML;
                const msg = instrId === 'loan-instruction' ? 'SILAKAN SCAN BARCODE BUKU...' : 'SILAKAN TEMPEL KARTU...';
                const color = instrId === 'loan-instruction' ? 'text-blue-600' : 'text-green-600';
                instr.innerHTML = `<span class="${color} font-bold animate-pulse">${msg}</span>`;
                setTimeout(() => { instr.innerHTML = oldText; }, 5000);
            }


        }
    };

    document.addEventListener('DOMContentLoaded', () => { 
        // ... (Existing Logic) ...
        
        // REPLACED: Handle Login Success to Update Banner
        const handleLoginSuccess = (data) => {
            isLoggedIn = true;
            showView('dashboard-page'); 
            closeModal('login-modal');
            
            // UPDATE BANNER DOM
            const banner = document.getElementById('member-info-banner');
            if(banner) {
                banner.classList.remove('hidden');
                if(data.data.nis) document.getElementById('banner-nis').innerText = data.data.nis;
                if(data.data.class) document.getElementById('banner-class').innerText = data.data.class;
                // Note: Make sure controller returns 'angkatan' in 'data' object
                if(data.data.angkatan) document.getElementById('banner-angkatan').innerText = data.data.angkatan;
            }

            document.getElementById('nav-user-name').innerText = data.data.name;
            document.getElementById('dash-user-name').innerText = data.data.name;
            // ... (rest)
            logoutButton.classList.remove('hidden');
            if(logoutButtonMobile) logoutButtonMobile.classList.remove('hidden');
            loadProfileData(data.data.nis);
            document.getElementById('login-santri-error').classList.add('hidden');
            document.getElementById('form-login-santri').reset();
        };

        // ...

        // NEW: Listener for Attendance Scanner Button
        const btnScanAbsen = document.getElementById('activate-scan-btn');
        if(btnScanAbsen) {
            btnScanAbsen.addEventListener('click', () => {
                activateScanner('active-rfid-input', 'scan-pulse', 'scan-instruction');
            });
        }
        
        // Remove old 'tap-kartu-btn' listener if it exists to avoid conflict
        // (Since we replaced the HTML ID, the old listener won't attach naturally, but good to be clean)


    




    <!-- LOGIN MODAL MOVED TO BOTTOM OF BODY -->

<script>
    // Global Idle Timer (60 seconds)
    (function() {
        const idleLimit = 60 * 1000; 
        let idleTimer;
        const resetIdle = () => {
            clearTimeout(idleTimer);
            idleTimer = setTimeout(() => window.location.href = "{{ url('/') }}", idleLimit);
        };
        ['click','mousemove','keypress','touchstart','scroll'].forEach(evt => document.addEventListener(evt, resetIdle));
        resetIdle();
    })();
</script>


<script>
    document.addEventListener('DOMContentLoaded', () => {
    try {
        // alert('System Loading...'); // Uncomment if needed to check basic JS load
    // GUARANTEED FIX: Only consider logged in if $member data ACTUALLY exists.
    // This ignores ghost sessions where session=true but data=null.
    let isLoggedIn = {{ $member ? 'true' : 'false' }};
    
    // Robust parsing for LocalStorage
    let sbpSubmissions = [];
    try {
        const storedSbp = localStorage.getItem('sbpSubmissions');
        if (storedSbp) {
            sbpSubmissions = JSON.parse(storedSbp);
        }
    } catch (e) {
        console.error("Error parsing SBP data:", e);
        localStorage.removeItem('sbpSubmissions'); // Clear corrupted data
    }

    // Defaults if empty
    if (!sbpSubmissions || !Array.isArray(sbpSubmissions) || sbpSubmissions.length === 0) {
        sbpSubmissions = [
            { id: 'sbp-1667888001', nama: 'Ahmad Farhan', nis: '102030', email: 'ahmad@email.com', tanggal: '2025-10-28', status: 'Menunggu', alasan: '' },
            { id: 'sbp-1667888002', nama: 'Siti Aisyah', nis: '102031', email: 'siti@email.com', tanggal: '2025-10-27', status: 'Menunggu', alasan: '' },
            { id: 'sbp-1667888003', nama: 'Budi Santoso', nis: '102032', email: 'budi@email.com', tanggal: '2025-10-26', status: 'Disetujui', alasan: '' },
            { id: 'sbp-1667888004', nama: 'Rizky Amelia', nis: '102033', email: 'rizky@email.com', tanggal: '2025-10-25', status: 'Ditolak', alasan: 'Masih ada pinjaman buku.' },
        ];
    }
    let absenHariIni = ['Siti Aisyah (102031)'];

    const pageViews = document.querySelectorAll('.page-view');
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const iconOpen = document.getElementById('icon-open');
    const iconClose = document.getElementById('icon-close');
    const profileNavLink = document.getElementById('profile-nav-link');
    const profileNavMobile = document.getElementById('profile-nav-mobile');
    const logoutButton = document.getElementById('logout-button');
    const logoutButtonMobile = document.getElementById('logout-button-mobile');
    const sbpStatusView = document.getElementById('sbp-status-view');
    const navLinksContainer = document.getElementById('nav-links'); // Desktop Nav

    // Initial State: Hide everything except Navbar (which is restricted) or show Login
    // But since it's a "Portal", we force Login first.
    
    // Expose critical UI functions to Global Scope for inline onclicks
    window.showView = (viewId) => {
        if (!isLoggedIn) {
             window.openModal('login-modal');
             return;
        }
        pageViews.forEach(view => { view.classList.toggle('active', view.id === viewId); });
        window.scrollTo(0, 0);
        if(mobileMenu) mobileMenu.classList.add('hidden');
        if(iconOpen) iconOpen.classList.remove('hidden');
        if(iconClose) iconClose.classList.add('hidden');
    };

    // --- LOGIN HANDLER ---
    window.handleLoginSuccess = (data) => {
        // 1. Show Success Feedback
        const btn = document.querySelector('#form-login-santri button[type="submit"]');
        if(btn) {
            btn.innerHTML = `<svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Berhasil! Mengalihkan...`;
            btn.classList.remove('bg-green-600', 'hover:bg-green-700');
            btn.classList.add('bg-green-500', 'cursor-not-allowed');
        }

        // 2. Force Redirect with Cache Busting
        console.log("Login Success. Preparing redirect...");
        setTimeout(() => {
            const timestamp = new Date().getTime();
            let targetUrl = "{{ route('portal.index') }}?t=" + timestamp;
            
            if(data.data && data.data.redirect) {
                targetUrl = data.data.redirect + '?t=' + timestamp;
            }
            
            console.log("Redirecting to: " + targetUrl);
            window.location.href = targetUrl;
        }, 800); 
    };

    // On Load Check
    if (!isLoggedIn) {
        const loginModal = document.getElementById('login-modal');
        if(loginModal) loginModal.classList.remove('hidden');
        const dashboard = document.getElementById('main-landing-page');
        if(dashboard) dashboard.classList.remove('active'); 
    } else {
         window.showView('main-landing-page');
    }

    window.scrollToElement = (targetId) => {
        const targetElement = document.getElementById(targetId);
        if (targetElement) {
            if (!document.getElementById('main-landing-page').classList.contains('active')) {
                window.showView('main-landing-page');
                setTimeout(() => { window.scrollTo({ top: targetElement.offsetTop - 70, behavior: 'smooth' }); }, 100);
            } else {
                window.scrollTo({ top: targetElement.offsetTop - 70, behavior: 'smooth' });
            }
        }
        if(mobileMenu) mobileMenu.classList.add('hidden');
        if(iconOpen) iconOpen.classList.remove('hidden');
        if(iconClose) iconClose.classList.add('hidden');
    };

    window.openModal = (modalId) => {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            const content = modal.querySelector('.modal-content');
            if(content) {
                setTimeout(() => { modal.classList.add('opacity-100'); content.classList.remove('scale-95'); content.classList.add('scale-100'); }, 10);
            }
        }
    };

    window.closeModal = (modalId) => {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('opacity-100');
            const content = modal.querySelector('.modal-content');
            if(content) {
                content.classList.remove('scale-100'); 
                content.classList.add('scale-95');
            }
            setTimeout(() => { modal.classList.add('hidden'); }, 300);
        }
    };

    // Focus Management for RFID
    const loginNisInput = document.getElementById('login-nis');
    if (!isLoggedIn && loginNisInput) {
        setTimeout(() => loginNisInput.focus(), 500);
        document.addEventListener('click', (e) => {
            if (document.getElementById('login-modal') && !document.getElementById('login-modal').classList.contains('hidden')) {
                 loginNisInput.focus();
            }
        });
    }

    const handleLogin = (nisOrRfid) => {
        // EXTREME DEBUGGING
        // alert('Processing Login for: ' + nisOrRfid); 

        // Disable inputs while loading and show visible text
        const btn = document.querySelector('#form-login-santri button[type="submit"]');
        const loginText = btn ? btn.innerText : '';
        if(btn) {
            btn.disabled = true;
            btn.innerText = "Memproses...";
        }

        // Simple payload - backend handles check
        const payload = { nis: nisOrRfid };
        
        fetch('{{ route('portal.login') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(payload)
        })
        .then(async response => {
            const text = await response.text();
            let data;
            try {
                data = JSON.parse(text);
            } catch (e) {
                console.error("Non-JSON response:", text);
                throw new Error('Server Return Error (Not JSON)');
            }

            if (!response.ok) {
                throw new Error(data.message || 'Login failed');
            }
            return data;
        })
        .then(data => {
            if (data.status === 'success') {
                handleLoginSuccess(data);
            } else {
                throw new Error(data.message || 'Login gagal.');
            }
        })
        .catch(error => {
            console.error('Login Error:', error);
            showLoginError(error.message);
        })
        .finally(() => {
             if(btn) {
                 btn.disabled = false;
                 btn.innerText = "Masuk dengan NIS"; // Reset text
             }
        });
    };
    window.handleLogin = handleLogin; // PROCESS: Expose for inline usage
    
    // Helper to avoid duplicate code from retry logic - REMOVED DUPLICATE DEFINITION
    // The main handleLoginSuccess is defined earlier in the script.


    const showLoginError = (msg) => {
        document.getElementById('login-santri-error').innerHTML = `<svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg><span>${msg}</span>`;
        document.getElementById('login-santri-error').classList.remove('hidden');
    };

    const handleLogout = () => {
        fetch('{{ route('portal.logout') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(() => {
            isLoggedIn = false;
            location.reload(); 
        });
    };

    const loadProfileData = (nis) => {
        if (nis === '102030') {
            const mySbp = sbpSubmissions.find(s => s.nis === nis);
            if (mySbp) {
                if (mySbp.status === 'Menunggu') {
                    sbpStatusView.innerHTML = `<p class="font-medium text-yellow-600">Status: Menunggu Persetujuan</p><p class="text-sm text-gray-500 mt-2">Pengajuan Anda sedang ditinjau oleh petugas.</p>`;
                } else if (mySbp.status === 'Disetujui') {
                    sbpStatusView.innerHTML = `<p class="font-medium text-green-600">Status: Disetujui</p><p class="text-sm text-gray-500 mt-2">Silakan ambil surat di perpustakaan.</p>`;
                } else {
                    sbpStatusView.innerHTML = `<p class="font-medium text-red-600">Status: Ditolak</p><p class="text-sm text-gray-500 mt-2">Alasan: ${mySbp.alasan}</p><button data-action="open-modal" data-modal="sbp-modal" class="mt-2 text-sm text-blue-600 hover:underline">Ajukan Ulang</button>`;
                }
            } else {
                sbpStatusView.innerHTML = `<p class="text-gray-600">Anda belum mengajukan SBP.</p><button data-action="open-modal" data-modal="sbp-modal" class="mt-2 text-sm text-blue-600 hover:underline">Ajukan Sekarang</button>`;
            }
        }
    };
    
    const showModalNotification = (modalId, message, isError = false) => {
        const notifElement = document.getElementById(`${modalId}-notification`);
        if (!notifElement) return;
        notifElement.textContent = message;
        notifElement.classList.remove('hidden', 'fade-out-notif', 'bg-green-100', 'text-green-700', 'bg-red-100', 'text-red-700', 'bg-yellow-100', 'text-yellow-700');
        if (isError === 'warning') { notifElement.classList.add('bg-yellow-100', 'text-yellow-700'); } else if (isError) { notifElement.classList.add('bg-red-100', 'text-red-700'); } else { notifElement.classList.add('bg-green-100', 'text-green-700'); }
        void notifElement.offsetWidth;
        notifElement.classList.add('fade-out-notif');
    };

    document.body.addEventListener('click', (e) => {
        const target = e.target.closest('[data-action]');
        if (!target) return;
        e.preventDefault();
        const action = target.getAttribute('data-action');
        switch(action) {
            case 'show-view': showView(target.getAttribute('data-view')); break;
            case 'scroll-to': scrollToElement(target.getAttribute('data-target')); break;
            case 'open-modal': openModal(target.getAttribute('data-modal')); break;
            case 'close-modal': closeModal(target.getAttribute('data-modal')); break;
            case 'show-profile': if (isLoggedIn) { showView('profile-page'); } else { openModal('login-modal'); } break;
            case 'logout': openModal('logout-modal'); break;
        }
        if (target.classList.contains('mobile-nav-link')) { mobileMenu.classList.add('hidden'); iconOpen.classList.remove('hidden'); iconClose.classList.add('hidden'); }
    });

    mobileMenuButton && mobileMenuButton.addEventListener('click', () => { mobileMenu.classList.toggle('hidden'); iconOpen.classList.toggle('hidden'); iconClose.classList.toggle('hidden'); });
    
    // Safety check for optional elements
    const layananBtn = document.getElementById('layanan-desktop-btn');
    const layananDropdown = document.getElementById('layanan-desktop-dropdown');
    if (layananBtn && layananDropdown) {
        layananBtn.addEventListener('click', () => { layananDropdown.classList.toggle('hidden'); });
        window.addEventListener('click', (e) => { if (!layananBtn.contains(e.target) && !layananDropdown.contains(e.target)) { layananDropdown.classList.add('hidden'); } });
    }

    // --- Login Logic Revised ---
    const loginForm = document.getElementById('form-login-santri');
    const rfidLoginView = document.getElementById('rfid-login-view');
    const btnModeRfid = document.getElementById('btn-mode-rfid');
    const btnCancelRfid = document.getElementById('btn-cancel-rfid');
    const rfidLoginInput = document.getElementById('rfid-login-input');

    if (loginForm) {
        loginForm.addEventListener('submit', (e) => { 
            e.preventDefault(); 
            const nisInput = document.getElementById('login-nis');
            if(nisInput) handleLogin(nisInput.value); 
        });
    }

    // Switch to RFID Mode
    const loginFormView = document.getElementById('login-form-view');
    if(btnModeRfid && loginFormView && rfidLoginView && rfidLoginInput) {
        btnModeRfid.addEventListener('click', () => {
             loginFormView.classList.add('hidden');
             rfidLoginView.classList.remove('hidden');
        });
    }

    // New: Click to Activate Login Scanner
    const startLoginScanBtn = document.getElementById('start-login-scan-btn');
    if(startLoginScanBtn) {
        startLoginScanBtn.addEventListener('click', () => { activateScanner('login'); });
    }

    const startLoanScanBtn = document.getElementById('activate-loan-btn');
    if(startLoanScanBtn) {
        startLoanScanBtn.addEventListener('click', () => { activateScanner('loan'); });
    }

    // Confirm Logout Button
    const confirmLogoutBtn = document.getElementById('confirm-logout-btn');
    if(confirmLogoutBtn) {
         confirmLogoutBtn.addEventListener('click', () => {
             handleLogout();
         });
    }

    // Cancel RFID Mode
    if(btnCancelRfid && rfidLoginView && loginFormView) {
        btnCancelRfid.addEventListener('click', () => {
             rfidLoginView.classList.add('hidden');
             loginFormView.classList.remove('hidden');
        });
    }

    // Keep focus on RFID input when in RFID mode
    if(rfidLoginInput && rfidLoginView) {
        rfidLoginInput.addEventListener('blur', () => {
            if(!rfidLoginView.classList.contains('hidden')) {
                 setTimeout(() => rfidLoginInput.focus(), 100);
            }
        });

        // Handle RFID Input
        let rfidBuffer = '';
        let lastKeyTimeLogin = Date.now();
        
        rfidLoginInput.addEventListener('keydown', (e) => {
            const currentTime = Date.now();
            if (e.key === 'Enter') {
                if (rfidBuffer.length > 3) {
                    handleLogin(rfidBuffer); // Submit login
                    rfidBuffer = '';
                }
                if (currentTime - lastKeyTimeLogin > 100) rfidBuffer = '';
                rfidBuffer += e.key;
            }
            lastKeyTimeLogin = currentTime;
        });
    }

    // --- ATTENDANCE LOGIC ---
    // --- ATTENDANCE LOGIC ---
    // --- ATTENDANCE LOGIC ---
    window.handleAbsen = (kode) => {
        const notif = document.getElementById('absen-notification');
        
        fetch('{{ route('portal.attendance.store') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ code: kode }) 
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                showModalNotification('absen', data.message, false);
                // Optional: Update counter without reload if possible, otherwise just stay for speed
                // setTimeout(() => location.reload(), 2000); 
            } else if (data.status === 'warning') {
                showModalNotification('absen', data.message, 'warning');
            } else {
                showModalNotification('absen', data.message, true);
            }
        })
        .catch(err => {
             showModalNotification('absen', 'Gagal terhubung ke server.', true);
             console.error(err);
        });
        
        // Reset inputs
        if(document.getElementById('manual-absen-form')) document.getElementById('manual-absen-form').reset();
        if(document.getElementById('active-rfid-input')) document.getElementById('active-rfid-input').value = '';
    };

    // RFID Buffer Logic for Attendance Modal
    const activeRfidInput = document.getElementById('active-rfid-input');
    if(activeRfidInput) {
        // Keep focus
        const attendanceModal = document.getElementById('absen-modal');
        attendanceModal.addEventListener('click', () => {
             if(!activeRfidInput.matches(':focus') && !document.getElementById('manual-absen-input').matches(':focus')) {
                 activeRfidInput.focus();
             }
        });

        // Capture Input
        let absenBuffer = '';
        let lastKeyTimeAbsen = Date.now();
        
        activeRfidInput.addEventListener('keydown', (e) => {
            const currentTime = Date.now();
            if (e.key === 'Enter') {
                if (absenBuffer.length > 2) {
                    handleAbsen(absenBuffer);
                    absenBuffer = '';
                }
                if (currentTime - lastKeyTimeAbsen > 100) absenBuffer = ''; // Reset if too slow (manual typing)
                absenBuffer += e.key;
            }
            lastKeyTimeAbsen = currentTime;
        });
    }
    




    const swiperContainer = document.querySelector('.swiper-container');
    if(swiperContainer) {
        const swiper = new Swiper('.swiper-container', {
            effect: 'slide', grabCursor: true, centeredSlides: false, slidesPerView: 2, spaceBetween: 20, loop: true,
            pagination: { el: '.swiper-pagination', clickable: true, },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev', },
            autoplay: { delay: 3000, disableOnInteraction: false, },
            breakpoints: { 640: { slidesPerView: 3, spaceBetween: 20, }, 768: { slidesPerView: 4, spaceBetween: 30, }, 1024: { slidesPerView: 5, spaceBetween: 30, }, }
        });
    }
    } catch (criticalError) {
        alert("CRITICAL SYSTEM ERROR: " + criticalError.message);
        console.error(criticalError);
    }
});
</script>

    <div id="login-modal" class="modal-overlay fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-100 {{ $member ? 'hidden' : '' }}" data-modal="login-modal" style="{{ !$member ? 'display: flex !important; opacity: 1 !important;' : '' }}">
        <div class="modal-content bg-white w-full max-w-sm p-8 rounded-lg shadow-lg transform scale-100 relative">
            <a href="{{ url('/') }}" class="absolute top-4 left-4 text-gray-400 hover:text-green-600 transition" title="Kembali">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div class="text-center mb-6">
                <!-- Logo -->
                <div class="flex flex-col items-center justify-center mb-4">
                     <img src="{{ asset('logo_ibs.png') }}" alt="Logo IBS" class="w-auto h-16 mx-auto mb-3 object-contain">
                     <h1 class="text-2xl font-bold text-green-600">IHSAN-LIB</h1>
                     <p class="text-gray-500 text-sm">Portal Santri & Perpustakaan</p>
                </div>
            </div>

            <!-- Hint Box REMOVED -->
            
            <div id="login-container">
                <div id="login-form-view">
                <form id="form-login-santri" class="space-y-4" method="POST" action="{{ route('login.post') }}">
                @csrf
                <!-- Note: 'login.post' usually points to Admin login, but here we need Portal Login. -->
                <!-- Correcting action to point to Portal Login -->
                <input type="hidden" name="login_source" value="portal"> 
                
                <!-- RE-DIRECT FORM ACTION TO PORTAL LOGIN -->
                </form>
                <!-- Re-writing form tag correctly below due to complexity -->
                
                <form id="form-login-santri" class="space-y-4" method="POST" action="{{ route('portal.login') }}">
                    @csrf
                <label for="login-nis" class="block text-sm font-medium text-gray-700 mb-1">Nomor Induk Santri (NIS)</label>
                <input type="text" name="nis" id="login-nis" class="w-full px-4 py-3 bg-green-50 border border-green-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all font-mono" placeholder="Masukkan NIS Anda..." required>
            </div>
            
            <!-- Error Display from Session -->
            @if(session('error'))
            <div id="login-session-error" class="text-sm text-red-600 bg-red-50 p-3 rounded-lg flex items-center justify-center border border-red-100 animate-pulse">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
            @endif

            <!-- Old JS Error Box (Kept hidden just in case) -->
            <div id="login-santri-error" class="text-sm text-red-600 bg-red-50 p-3 rounded-lg hidden flex items-center justify-center border border-red-100"></div>

            <button type="submit" class="w-full py-2 px-4 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-md transition duration-300 flex justify-center items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Masuk dengan NIS
            </button>
                    
            <div class="relative flex py-2 items-center">
                <div class="flex-grow border-t border-gray-200"></div>
                <span class="flex-shrink-0 mx-4 text-gray-400 text-xs">ATAU</span>
                <div class="flex-grow border-t border-gray-200"></div>
            </div>

            <button type="button" id="btn-mode-rfid" class="w-full py-2 px-4 bg-white text-green-700 font-bold rounded-lg border-2 border-green-600 hover:bg-green-50 transition duration-300 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                Tap Kartu RFID
            </button>
            </form>
            
            <div class="mt-4 text-center border-t pt-2">
                 <div class="flex flex-col gap-1">
                     <a href="{{ route('landing') }}" class="text-xs text-gray-400 hover:text-gray-600 transition">Kembali ke Beranda</a>
                     <form action="{{ route('logout') }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit" class="text-[10px] text-red-300 hover:text-red-500 underline" onclick="return confirm('Force Logout?');">
                            Reset Sesi (Darurat/Stuck)
                        </button>
                     </form>
                 </div>
            </div>
            </div> <!-- Close login-form-view -->

                 <!-- RFID Mode View (Initially Hidden) -->
                 <div id="rfid-login-view" class="hidden text-center py-4 transition-all duration-300">
                     <div class="flex flex-col items-center justify-center">
                         <!-- Green Fingerprint Button (Activates Scanner) -->
                        <button id="start-login-scan-btn" type="button" class="group relative w-32 h-32 mx-auto bg-green-50 rounded-full flex items-center justify-center mb-6 transition-all duration-300 hover:bg-green-100 hover:scale-105 active:scale-95 focus:outline-none focus:ring-4 focus:ring-green-200">
                             <div id="login-pulse" class="absolute inset-0 bg-green-400 rounded-full opacity-0 transition-opacity duration-300"></div>
                            <svg class="w-16 h-16 text-green-600 group-hover:text-green-700 transition-colors z-10" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.2-2.848.578-4.137m.087-2.67C5.32 2.68 7.352 1.5 10 1.5c2.648 0 4.68 1.18 5.335 2.687"></path>
                            </svg>
                        </button>
                        
                        <p id="login-instruction" class="text-gray-500 text-sm mb-6">Klik ikon di atas untuk <span class="font-bold text-green-600">MENGAKTIFKAN SCANNER</span></p>
                    </div>
                    
                    <!-- Hidden real input for RFID -->
                    <input type="text" id="rfid-login-input" class="opacity-0 absolute top-0 left-0 w-full h-full cursor-default -z-10" autocomplete="off">

                     <button type="button" id="btn-cancel-rfid" class="mt-4 px-6 py-3 bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 rounded-full font-bold shadow-sm transition-all flex items-center gap-2 mx-auto text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        BATALKAN PINDAI
                    </button>
            </div>
        </div>
    </div>
</div>

    <!-- MOVED MODALS (Fixed Syntax Error) -->
    <div id="sbp-modal" class="modal-overlay fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50 hidden" data-modal="sbp-modal">
        <div class="modal-content bg-white w-full max-w-lg p-6 rounded-xl shadow-lg transform scale-95">
            <div class="flex justify-between items-center mb-4"><h3 class="text-xl font-semibold text-gray-900">Pengajuan Surat Bebas Pustaka</h3><button data-action="close-modal" data-modal="sbp-modal" class="text-gray-500 hover:text-gray-800 text-3xl">&times;</button></div>
            <div id="sbp-notification" class="p-4 mb-4 rounded-md text-sm hidden"></div>
            <form id="form-sbp" class="space-y-4">
                <div><label for="sbp-nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label><input type="text" id="sbp-nama" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required></div>
                 <div><label for="sbp-nis" class="block text-sm font-medium text-gray-700">NIS (Nomor Induk Santri)</label><input type="text" id="sbp-nis" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required></div>
                 <div><label for="sbp-kelas" class="block text-sm font-medium text-gray-700">Kelas Terakhir</label><input type="text" id="sbp-kelas" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: XII-A" required></div>
                 <div><label for="sbp-email" class="block text-sm font-medium text-gray-700">Email Aktif</label><input type="email" id="sbp-email" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Untuk menerima notifikasi" required></div>
                <div class="flex items-start"><input id="sbp-konfirmasi" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded mt-1 focus:ring-blue-500" required><label for="sbp-konfirmasi" class="ml-2 block text-sm text-gray-700">Saya menyatakan bahwa saya sudah tidak memiliki tanggungan peminjaman buku.</label></div>
                <button type="submit" class="w-full px-4 py-2 font-semibold text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-700">Kirim Pengajuan</button>
            </form>
        </div>
    </div>

    <div id="loan-modal" class="modal-overlay fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50 hidden" data-modal="loan-modal">
        <div class="modal-content bg-white w-full max-w-sm p-8 rounded-2xl shadow-2xl transform scale-95 relative">
            <button data-action="close-modal" data-modal="loan-modal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <div class="text-center">
                <h3 class="text-xl font-bold text-gray-800 mb-6 font-heading">Pinjam Buku Mandiri</h3>
                <div id="loan-notification" class="p-3 mb-4 rounded-lg text-sm hidden font-medium transition-all duration-300"></div>
                
                <!-- CHECK SECTION (Step 1) -->
                <div id="loan-check-section">
                    <p class="text-gray-500 text-sm mb-4">Masukkan Kode Buku atau Scan Barcode:</p>
                    <form id="form-loan-manual" class="flex flex-col gap-3" onsubmit="event.preventDefault(); handleLoanManualSubmit();">
                         <div class="relative">
                            <input type="text" id="book-code-input" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 font-mono text-center" placeholder="Scan/Input Kode..." autofocus>
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                         </div>
                         <button type="submit" class="w-full py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 shadow transition">CEK BUKU</button>
                    </form>
                </div>

                <!-- CONFIRM SECTION (Step 2 - Hidden by Default) -->
                <div id="loan-confirm-section" class="hidden animate-fade-in-up">
                    <div class="text-left mb-4">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Konfirmasi Peminjaman</p>
                        <h4 id="loan-confirm-title" class="text-lg font-bold text-gray-800 leading-tight">Judul Buku</h4>
                    </div>
                    
                    <div id="loan-confirm-details" class="mb-6"></div>

                    <div class="flex gap-2">
                        <button onclick="cancelLoan()" class="flex-1 py-2 bg-gray-100 text-gray-700 font-bold rounded-lg hover:bg-gray-200 transition">Batal</button>
                        <button id="btn-confirm-loan" class="flex-1 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 shadow transition">YA, PINJAM</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div id="logout-modal" class="modal-overlay fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50 hidden" data-modal="logout-modal">
        <div class="modal-content bg-white w-full max-w-sm p-6 rounded-xl shadow-lg transform scale-95 relative text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Konfirmasi Logout</h3>
            <p class="text-gray-500 text-sm mb-6">Apakah Anda yakin ingin keluar dari sesi ini?</p>
            <div class="flex gap-3 justify-center">
                <button data-action="close-modal" data-modal="logout-modal" class="px-5 py-2 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition">Batal</button>
                <button id="confirm-logout-btn" class="px-5 py-2 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 shadow-md transition transform hover:scale-105">Ya, Logout</button>
            </div>
        </div>
    </div>
    
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Basic Handlers
    window.showModalNotification = (type, msg, isError) => {
        const notif = document.getElementById(type + '-notification');
        if(notif) {
             notif.innerHTML = msg;
             notif.classList.remove('hidden', 'bg-red-100', 'text-red-700', 'bg-green-100', 'text-green-700');
             notif.classList.add('block', isError ? 'bg-red-100' : 'bg-green-100', isError ? 'text-red-700' : 'text-green-700');
             setTimeout(() => notif.classList.add('hidden'), 5000);
        }
    };
    
    // Explicit Loan Handler
    window.checkBookLoan = (code) => {
        const notif = document.getElementById('loan-notification');
        const checkSection = document.getElementById('loan-check-section');
        const confirmSection = document.getElementById('loan-confirm-section');
        
        // Reset View
        document.getElementById('loan-confirm-title').innerText = 'Memuat...';
        document.getElementById('loan-confirm-details').innerHTML = '';
        if(notif) notif.classList.add('hidden');

        fetch('{{ route('portal.loan.check') }}', { 
            method: 'POST', 
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ book_code: code }) 
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                // Show Confirmation
                checkSection.classList.add('hidden');
                confirmSection.classList.remove('hidden');
                
                document.getElementById('loan-confirm-title').innerText = data.data.title;
                document.getElementById('loan-confirm-details').innerHTML = `
                    <div class="space-y-2 text-left bg-gray-50 p-3 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-500">Kode Buku: <span class="font-mono font-bold text-gray-700">${data.data.barcode || '-'}</span></p>
                        <p class="text-xs text-gray-500">Soba Tersedia: <span class="font-bold text-green-600">${data.data.stock} Eks</span></p>
                        <p class="text-xs text-gray-500">Tanggal Pinjam: <span class="font-bold text-gray-700">${data.data.loan_date}</span></p>
                        <p class="text-xs text-gray-500">Jatuh Tempo: <span class="font-bold text-red-600">${data.data.due_date}</span></p>
                    </div>
                `;
                // Bind Confirm Button
                document.getElementById('btn-confirm-loan').onclick = () => confirmLoan(code);
            } else {
                showModalNotification('loan', data.message, true);
            }
        })
        .catch(err => {
            console.error(err);
            showModalNotification('loan', 'Gagal memproses. Cek koneksi.', true);
        });
    };

    window.confirmLoan = (code) => {
         fetch('{{ route('portal.loan.store') }}', { 
            method: 'POST', 
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ book_code: code }) 
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                showModalNotification('loan', data.message, false);
                // Reset UI
                document.getElementById('loan-confirm-section').classList.add('hidden');
                document.getElementById('loan-check-section').classList.remove('hidden');
                document.getElementById('book-code-input').value = '';
                setTimeout(() => location.reload(), 1500); 
            } else {
                showModalNotification('loan', data.message, true);
            }
        })
        .catch(err => {
             showModalNotification('loan', 'Error saat proses akhir.', true);
        });
    };

    window.cancelLoan = () => {
         document.getElementById('loan-confirm-section').classList.add('hidden');
         document.getElementById('loan-check-section').classList.remove('hidden');
         document.getElementById('book-code-input').focus();
    };

    window.handleLoanManualSubmit = () => {
        const code = document.getElementById('book-code-input').value;
        if(code) {
            checkBookLoan(code);
        } else {
            alert('Masukkan kode buku!');
        }
    };

    window.handleAbsenManualSubmit = () => {
        const code = document.getElementById('manual-absen-input').value;
        if(code) {
            handleAbsen(code);
        } else {
            alert('Masukkan NIS/RFID!');
        }
    };
    

    const swiperContainer = document.querySelector('.swiper-container');
    if(swiperContainer) {
        const swiper = new Swiper('.swiper-container', {
            effect: 'slide', grabCursor: true, centeredSlides: false, slidesPerView: 2, spaceBetween: 20, loop: true,
            pagination: { el: '.swiper-pagination', clickable: true, },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev', },
            autoplay: { delay: 3000, disableOnInteraction: false, },
            breakpoints: { 640: { slidesPerView: 3, spaceBetween: 20, }, 768: { slidesPerView: 4, spaceBetween: 30, }, 1024: { slidesPerView: 5, spaceBetween: 30, }, }
        });
    }

    // --- MOBILE MENU LOGIC ---
    const mobileMenuBtn = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const iconOpen = document.getElementById('icon-open');
    const iconClose = document.getElementById('icon-close');

    if(mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
             // Toggle Hidden Class
             if(mobileMenu.classList.contains('hidden')) {
                  mobileMenu.classList.remove('hidden');
                  iconOpen.classList.add('hidden');
                  iconClose.classList.remove('hidden');
             } else {
                  mobileMenu.classList.add('hidden');
                  iconOpen.classList.remove('hidden');
                  iconClose.classList.add('hidden');
             }
        });
        
        // Close on link click AND Perform Action
        document.querySelectorAll('.mobile-nav-link').forEach(link => {
            link.addEventListener('click', (e) => {
                 mobileMenu.classList.add('hidden');
                 if(iconOpen) iconOpen.classList.remove('hidden');
                 if(iconClose) iconClose.classList.add('hidden');

                 // Handle Actions
                 const action = link.getAttribute('data-action');
                 const view = link.getAttribute('data-view');
                 const modalId = link.getAttribute('data-modal');

                 if(action === 'show-view' && view) {
                     if(typeof window.showView === 'function') {
                         window.showView(view);
                     } else {
                         // Fallback View Switcher
                         document.querySelectorAll('.page-view').forEach(el => el.classList.add('hidden'));
                         const target = document.getElementById(view);
                         if(target) target.classList.remove('hidden');
                         window.scrollTo({top: 0, behavior: 'smooth'});
                     }
                 }
                 
                 if(action === 'logout') {
                     const logoutModal = document.getElementById('logout-modal');
                     if(logoutModal) {
                         logoutModal.classList.remove('hidden');
                         setTimeout(() => logoutModal.classList.remove('opacity-0'), 10);
                     }
                 }
                 
                 if(action === 'open-modal' && modalId) {
                     const modal = document.getElementById(modalId);
                     if(modal) {
                         modal.classList.remove('hidden');
                         // Specific Logic for Absen to auto-focus
                         if(modalId === 'absen-modal' && typeof activateScanner === 'function') {
                             setTimeout(() => activateScanner('absen'), 300);
                         }
                     }
                 }
            });
        });
    }
    // --- END MOBILE MENU LOGIC ---

    // End of DOMContentLoaded
// End of DOMContentLoaded
});
</script>
<script>
    // Global Search Handler
    window.handleSearchInternal = () => {
        const query = document.getElementById('search-query-internal') ? document.getElementById('search-query-internal').value : '';
        const category = document.getElementById('search-category-internal') ? document.getElementById('search-category-internal').value : ''; // Get Category

        const hasilContainer = document.getElementById('hasil-pencarian-internal');
        
        if(!hasilContainer) return;

         // Loading State
        hasilContainer.innerHTML = '<div class="text-center py-8"><svg class="animate-spin h-8 w-8 text-green-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><p class="mt-2 text-gray-500 text-sm">Mencari buku...</p></div>';

        // Construct Query Params
        const params = new URLSearchParams();
        if(query) params.append('q', query);
        if(category) params.append('category', category);

        fetch('{{ route('portal.search') }}?' + params.toString())
        .then(res => res.json())
        .then(data => {
            hasilContainer.innerHTML = '';
            if(data.status === 'success' && data.data.length > 0) {
                let html = '<div class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200"><ul class="divide-y divide-gray-200">';
                data.data.forEach(book => {
                    html += `
                    <li>
                    <div class="px-4 py-4 sm:px-6 hover:bg-gray-50 transition duration-150 ease-in-out">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0 pr-4">
                                <h4 class="text-lg font-bold text-gray-900 truncate mb-1">${book.title}</h4>
                                <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                                    <p class="text-sm text-gray-600 flex items-center gap-1">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        ${book.author}
                                    </p>
                                    <p class="text-sm text-gray-500 flex items-center gap-1">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        ${book.publisher ?? '-'}
                                    </p>
                                </div>
                                <div class="flex items-center mt-2 gap-2">
                                    <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-md bg-blue-50 text-blue-700 border border-blue-100">${book.category ?? 'Umum'}</span>
                                    <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-medium rounded-md bg-gray-100 text-gray-600 border border-gray-200">Rak: ${book.shelf_location ?? '-'}</span>
                                </div>
                            </div>
                            <div class="flex-shrink-0 flex flex-col items-end gap-2">
                                 ${book.stock > 0 
                                    ? '<span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Tersedia</span>' 
                                    : '<span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Habis</span>'
                                 }
                                 <span class="text-xs text-gray-500 font-mono">Stok: ${book.stock}</span>
                            </div>
                        </div>
                    </div>
                    </li>`;
                });
                html += '</ul></div>';
                hasilContainer.innerHTML = html;
            } else {
                 hasilContainer.innerHTML = `
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <p class="text-lg text-gray-500 font-medium">Buku tidak ditemukan.</p>
                        <p class="text-sm text-gray-400">Coba kata kunci lain atau hubungi petugas.</p>
                    </div>
                `;
            }
        })
        .catch(err => {
            console.error(err);
            hasilContainer.innerHTML = '<p class="text-center text-red-500 py-4">Terjadi kesalahan saat mencari.</p>';
        });
    };
    
    // --- RETURN Logic ---
    // --- RETURN Logic ---
    window.checkBookReturn = (code) => {
        const notif = document.getElementById('return-notification');
        const checkSection = document.getElementById('return-check-section');
        const confirmSection = document.getElementById('return-confirm-section');

        // Reset View
        document.getElementById('return-confirm-title').innerText = 'Memuat...';
        document.getElementById('return-confirm-details').innerHTML = '';
        if(notif) notif.classList.add('hidden');

        fetch('{{ route('portal.return.check') }}', { 
            method: 'POST', 
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ book_code: code }) 
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                checkSection.classList.add('hidden');
                confirmSection.classList.remove('hidden');

                const isLate = data.data.fine > 0;
                document.getElementById('return-confirm-title').innerText = data.data.title;
                document.getElementById('return-confirm-details').innerHTML = `
                    <div class="space-y-2 text-left bg-gray-50 p-3 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-500">Durasi: <span class="font-bold text-gray-700">${data.data.duration}</span></p>
                        <p class="text-xs text-gray-500">Status: <span class="font-bold ${isLate ? 'text-red-600' : 'text-green-600'}">${isLate ? 'Terlambat ' + data.data.late_days + ' Hari' : 'Tepat Waktu'}</span></p>
                        ${isLate ? `<p class="text-xs text-gray-500">Denda: <span class="font-bold text-red-600">${data.data.formatted_fine}</span></p>` : ''}
                    </div>
                `;
                document.getElementById('btn-confirm-return').onclick = () => confirmReturn(code);
            } else {
                showModalNotification('return', data.message, true);
            }
        })
        .catch(err => {
             showModalNotification('return', 'Gagal cek buku. Cek koneksi.', true);
        });
    };

    window.confirmReturn = (code) => {
        fetch('{{ route('portal.return.store') }}', { 
            method: 'POST', 
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ book_code: code }) 
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                showModalNotification('return', data.message, false);
                document.getElementById('return-confirm-section').classList.add('hidden');
                document.getElementById('return-check-section').classList.remove('hidden');
                document.getElementById('return-code-input').value = '';
                setTimeout(() => location.reload(), 2000); 
            } else {
                showModalNotification('return', data.message, true);
            }
        })
        .catch(err => {
            showModalNotification('return', 'Gagal memproses pengembalian.', true);
        });
    };

    window.cancelReturn = () => {
         document.getElementById('return-confirm-section').classList.add('hidden');
         document.getElementById('return-check-section').classList.remove('hidden');
         document.getElementById('return-code-input').focus();
    };

    window.handleReturnManualSubmit = () => {
        const code = document.getElementById('return-code-input').value;
        if(code) { checkBookReturn(code); } else { alert('Masukkan kode buku!'); }
    };

    // --- SBP HANDLER (Global) ---
    window.handleSbpRequest = () => {
        const btn = document.getElementById('btn-submit-sbp');
        const loading = document.getElementById('sbp-loading');
        const errorBox = document.getElementById('sbp-error');
        const successBox = document.getElementById('sbp-success');

        if(btn) btn.classList.add('hidden');
        if(loading) loading.classList.remove('hidden');
        if(errorBox) errorBox.classList.add('hidden');
        if(successBox) successBox.classList.add('hidden');

        fetch('{{ route('portal.sbp.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({}) // Backend uses Session ID
        })
        .then(res => res.json())
        .then(data => {
            if(loading) loading.classList.add('hidden');
            
            if(data.status === 'success') {
                if(successBox) {
                    successBox.innerHTML = data.message;
                    successBox.classList.remove('hidden');
                }
                setTimeout(() => {
                   const modal = document.getElementById('sbp-form-modal');
                   if(modal) {
                        modal.classList.remove('opacity-100');
                        setTimeout(() => modal.classList.add('hidden'), 300);
                   }
                }, 2500);
            } else {
                if(btn) btn.classList.remove('hidden');
                if(errorBox) {
                    errorBox.innerHTML = data.message;
                    errorBox.classList.remove('hidden');
                }
            }
        })
        .catch(err => {
            console.error(err);
             if(loading) loading.classList.add('hidden');
             if(btn) btn.classList.remove('hidden');
             if(errorBox) {
                errorBox.innerHTML = 'Gagal terhubung ke server.';
                errorBox.classList.remove('hidden');
             }
        });
    };
</script>
</body>
</html>
