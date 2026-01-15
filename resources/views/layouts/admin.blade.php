<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'IHSAN-LIB - Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f0fdf4; } /* Green-50 background */
        /* Sidebar transition handled by Tailwind classes */
        .content-transition { transition: margin-left 0.3s ease; }
        /* CustomScrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #15803d; border-radius: 4px; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-green-50">

    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden lg:hidden transition-opacity duration-300 opacity-0"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="bg-green-900 text-white w-64 h-screen sidebar flex flex-col transition-transform duration-300 fixed top-0 left-0 z-30 shadow-xl border-r border-green-800 transform -translate-x-full lg:translate-x-0 lg:w-64">
        <!-- Sidebar Header -->
        <div class="h-20 flex items-center justify-center border-b border-gray-100 bg-white px-4 relative overflow-hidden transition-all duration-300">
             <!-- Full Logo State -->
            <div id="sidebar-logo" class="flex items-center gap-3 transition-all duration-300 w-full justify-center">
                <img src="{{ asset('logo_ibs.png') }}" alt="Logo IBS" class="h-10 w-auto object-contain drop-shadow-sm">
                <div class="flex flex-col whitespace-nowrap overflow-hidden">
                    <span class="text-[10px] font-bold text-green-700 tracking-[0.2em] uppercase leading-tight">IHSAN LIB</span>
                    <span class="font-bold tracking-wide text-green-800 text-sm leading-tight truncate uppercase">
                         @if(Auth::check())
                            | {{ Auth::user()->role === 'super_admin' ? 'ADMIN' : 'STAFF' }}
                        @else
                            | PERPUSTAKAAN
                        @endif
                    </span>
                </div>
            </div>
            
            <!-- Collapsed Logo State -->
            <div id="sidebar-logo-collapsed" class="absolute inset-0 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
                <img src="{{ asset('logo_ibs.png') }}" alt="Logo" class="w-8 h-8 object-contain drop-shadow-md">
            </div>
        </div>
        
        <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto overflow-x-hidden custom-scrollbar">
            @php
                $dashboardRoute = auth()->user()->role === 'super_admin' ? route('admin.index') : route('staff.index');
                $isActive = request()->routeIs('admin.index') || request()->routeIs('staff.index');
            @endphp
            <a href="{{ $dashboardRoute }}" class="flex items-center space-x-3 px-3 py-3 rounded-xl {{ $isActive ? 'bg-green-700 text-white shadow-lg shadow-green-900/50' : 'text-green-100/70 hover:bg-green-800 hover:text-white' }} transition-all group whitespace-nowrap">
                <svg class="w-6 h-6 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span class="sidebar-text font-medium opacity-100 transition-opacity duration-200">Dashboard</span>
            </a>
            
            <div class="sidebar-text text-[10px] font-bold text-green-400 uppercase tracking-wider px-4 mt-6 mb-2 opacity-100 transition-opacity duration-200">Menu Utama</div>

            <a href="{{ route('admin.members.index') }}" class="flex items-center space-x-3 px-3 py-3 rounded-xl {{ request()->routeIs('admin.members*') ? 'bg-green-700 text-white shadow-lg shadow-green-900/50' : 'text-green-100/70 hover:bg-green-800 hover:text-white' }} transition-all group whitespace-nowrap">
                <svg class="w-6 h-6 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span class="sidebar-text font-medium opacity-100 transition-opacity duration-200">Anggota</span>
            </a>
            <a href="{{ route('admin.books.index') }}" class="flex items-center space-x-3 px-3 py-3 rounded-xl {{ request()->routeIs('admin.books*') ? 'bg-green-700 text-white shadow-lg shadow-green-900/50' : 'text-green-100/70 hover:bg-green-800 hover:text-white' }} transition-all group whitespace-nowrap">
                <svg class="w-6 h-6 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <span class="sidebar-text font-medium opacity-100 transition-opacity duration-200">Buku & Pustaka</span>
            </a>

            @if(auth()->check() && auth()->user()->role === 'super_admin')
            <div class="sidebar-text text-[10px] font-bold text-green-400 uppercase tracking-wider px-4 mt-6 mb-2 opacity-100 transition-opacity duration-200">Administrator</div>
            <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 px-3 py-3 rounded-xl {{ request()->routeIs('admin.users*') ? 'bg-green-700 text-white shadow-lg shadow-green-900/50' : 'text-green-100/70 hover:bg-green-800 hover:text-white' }} transition-all group whitespace-nowrap">
                 <svg class="w-6 h-6 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span class="sidebar-text font-medium opacity-100 transition-opacity duration-200">Manajemen Staff</span>
            </a>
            @endif
            
            <div class="sidebar-text text-[10px] font-bold text-green-400 uppercase tracking-wider px-4 mt-6 mb-2 opacity-100 transition-opacity duration-200">Layanan</div>
            <!-- SBP Badge -->
            @php $pendingSbp = \App\Models\SbpRequest::where('status', 'pending')->count(); @endphp
            <a href="{{ route('admin.sbp.index') }}" class="flex items-center space-x-3 px-3 py-3 rounded-xl {{ request()->routeIs('admin.sbp*') ? 'bg-green-700 text-white shadow-lg shadow-green-900/50' : 'text-green-100/70 hover:bg-green-800 hover:text-white' }} transition-all group whitespace-nowrap">
                <svg class="w-6 h-6 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <div class="flex-1 flex justify-between items-center sidebar-text opacity-100 transition-opacity duration-200">
                    <span class="font-medium">Verifikasi SBP</span>
                    @if($pendingSbp > 0)
                        <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm blink-animation">{{ $pendingSbp }}</span>
                    @endif
                </div>
            </a>
            <a href="{{ route('admin.reports.index') }}" class="flex items-center space-x-3 px-3 py-3 rounded-xl {{ request()->routeIs('admin.reports*') ? 'bg-green-700 text-white shadow-lg shadow-green-900/50' : 'text-green-100/70 hover:bg-green-800 hover:text-white' }} transition-all group whitespace-nowrap">
                <svg class="w-6 h-6 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span class="sidebar-text font-medium opacity-100 transition-opacity duration-200">Laporan</span>
            </a>
            <a href="http://opac.ibs.sch.id" target="_blank" class="flex items-center space-x-3 px-3 py-3 rounded-xl text-green-100/70 hover:bg-green-800 hover:text-white transition-all group whitespace-nowrap">
                <svg class="w-6 h-6 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                <span class="sidebar-text font-medium opacity-100 transition-opacity duration-200">OPAC Eksternal</span>
            </a>
        </nav>
        
        <div class="p-4 border-t border-green-800 bg-green-950">
            <button onclick="openLogoutModal()" class="flex items-center justify-center lg:justify-start space-x-3 px-3 py-2 rounded-lg text-green-300 hover:text-red-400 hover:bg-green-900 w-full transition-colors group whitespace-nowrap">
                <svg class="w-6 h-6 flex-shrink-0 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                <span class="sidebar-text text-sm font-medium opacity-100 transition-opacity duration-200">Keluar</span>
            </button>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div id="main-content" class="lg:ml-64 flex flex-col min-h-screen content-transition bg-green-50/50 transition-all duration-300">
        
        <!-- Top Navbar -->
        <header class="bg-white/80 backdrop-blur-md shadow-sm h-16 flex items-center justify-between px-4 lg:px-6 sticky top-0 z-20 border-b border-gray-100">
            <div class="flex items-center">
                <button id="sidebar-toggle" class="text-green-700 hover:text-green-900 focus:outline-none p-2 rounded-lg hover:bg-green-50 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <h2 class="ml-4 text-lg lg:text-xl font-bold text-gray-800 tracking-tight">@yield('header', 'Dashboard')</h2>
            </div>
            <div class="flex items-center space-x-4">
                <div class="flex items-center gap-3 bg-green-50 px-3 py-1.5 rounded-full border border-green-100">
                     <div class="w-8 h-8 rounded-full bg-green-200 flex items-center justify-center text-green-700 font-bold border-2 border-green-200">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div class="hidden sm:flex flex-col text-right">
                        <span class="text-xs font-bold text-gray-800 leading-tight">{{ Auth::user()->name ?? 'Admin' }}</span>
                        <span class="text-[10px] uppercase font-semibold text-green-600 leading-tight">{{ str_replace('_', ' ', Auth::user()->role ?? 'Guest') }}</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Notification Toast -->
        @if(session('success') || session('error'))
        <div id="toast-notification" class="fixed top-20 right-6 z-50 transform transition-all duration-300 translate-y-0 opacity-100">
            <div class="flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-xl shadow-lg border-l-4 {{ session('success') ? 'border-green-500' : 'border-red-500' }}" role="alert">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-full {{ session('success') ? 'bg-green-100 text-green-500' : 'bg-red-100 text-red-500' }}">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        @if(session('success'))
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                        @else
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                        @endif
                    </svg>
                    <span class="sr-only">Check icon</span>
                </div>
                <div class="ml-3 text-sm font-normal">{{ session('success') ?? session('error') }}</div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#toast-notification" aria-label="Close" onclick="document.getElementById('toast-notification').remove()">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        </div>
        <script>
            setTimeout(() => {
                const toast = document.getElementById('toast-notification');
                if(toast) {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateY(-10px)';
                    setTimeout(() => toast.remove(), 300);
                }
            }, 5000);
        </script>
        @endif

        <!-- Main Content Area -->
        <main class="flex-1 p-4 lg:p-6 overflow-y-auto w-full">
            @yield('content')
        </main>
    </div>

    <!-- Maximum z-index used for modal -->
    <div id="logout-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50 hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-sm transform scale-100 transition-transform duration-300">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Konfirmasi Keluar</h3>
                <p class="text-gray-500 text-sm mt-2">Apakah Anda yakin ingin mengakhiri sesi ini?</p>
            </div>
            <div class="flex gap-3">
                <button onclick="closeLogoutModal()" class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">Batal</button>
                <button onclick="document.getElementById('logout-form').submit()" class="flex-1 px-4 py-2 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition-colors">Keluar</button>
            </div>
        </div>
    </div>

<script>
    // --- Sidebar Toggle Logic ---
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebarLogo = document.getElementById('sidebar-logo');
    const sidebarLogoCollapsed = document.getElementById('sidebar-logo-collapsed');
    const sidebarTexts = document.querySelectorAll('.sidebar-text');
    const mobileOverlay = document.getElementById('mobile-overlay');

    // Detect Mobile
    const isMobile = () => window.innerWidth < 1024;

    let isSidebarCollapsed = false; // Desktop State
    let isMobileSidebarOpen = false; // Mobile State

    function updateSidebarState() {
        if (isMobile()) {
            // Mobile State
            if (isMobileSidebarOpen) {
                // Open Sidebar (Slide in)
                sidebar.classList.remove('-translate-x-full');
                mobileOverlay.classList.remove('hidden', 'opacity-0');
            } else {
                // Close Sidebar (Slide out)
                sidebar.classList.add('-translate-x-full');
                mobileOverlay.classList.add('opacity-0');
                setTimeout(() => mobileOverlay.classList.add('hidden'), 300);
            }
            // Reset Desktop Classes just in case
            sidebar.classList.remove('w-20');
            sidebar.classList.add('w-64'); 
            mainContent.classList.remove('ml-64', 'ml-20'); // No margin on mobile
        } else {
            // Desktop State
            mobileOverlay.classList.add('hidden'); // Ensure overlay hidden
            
            // Restore Margin
            if(isSidebarCollapsed) {
                 sidebar.classList.remove('w-64');
                 sidebar.classList.add('w-20');
                 mainContent.classList.remove('ml-64');
                 mainContent.classList.add('ml-20');
                 sidebarLogo.classList.add('opacity-0');
                 sidebarLogoCollapsed.classList.remove('opacity-0', 'pointer-events-none');
                 sidebarTexts.forEach(text => text.classList.add('hidden', 'opacity-0'));
            } else {
                 sidebar.classList.remove('w-20');
                 sidebar.classList.add('w-64');
                 mainContent.classList.remove('ml-20');
                 mainContent.classList.add('ml-64');
                 sidebarLogo.classList.remove('opacity-0');
                 sidebarLogoCollapsed.classList.add('opacity-0', 'pointer-events-none');
                 sidebarTexts.forEach(text => text.classList.remove('hidden', 'opacity-0'));
            }
             // Ensure visible in desktop
             sidebar.classList.remove('-translate-x-full');
        }
    }

    // Toggle Button Click
    sidebarToggle.addEventListener('click', () => {
        if (isMobile()) {
            isMobileSidebarOpen = !isMobileSidebarOpen;
        } else {
            isSidebarCollapsed = !isSidebarCollapsed;
        }
        updateSidebarState();
    });

    // Close on Overlay Click (Mobile)
    mobileOverlay.addEventListener('click', () => {
        isMobileSidebarOpen = false;
        updateSidebarState();
    });

    // Handle Resize
    window.addEventListener('resize', () => {
        updateSidebarState();
    });

    // Initial State Check
    updateSidebarState();

    // Logout Modal Logic
    const logoutModal = document.getElementById('logout-modal');
    function openLogoutModal() {
        logoutModal.classList.remove('hidden');
        setTimeout(() => logoutModal.classList.remove('opacity-0'), 10);
    }
    function closeLogoutModal() {
        logoutModal.classList.add('opacity-0');
        setTimeout(() => logoutModal.classList.add('hidden'), 300);
    }
</script>

<!-- Logout Confirmation Modal -->


</body>
</html>
