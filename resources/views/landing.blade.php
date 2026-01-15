<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page - IHSAN-LIB</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50 border-b border-green-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center gap-3">
                    <img src="{{ asset('logo_ibs.png') }}" alt="Logo" class="w-auto h-12 object-contain">
                    <span class="font-bold text-xl text-green-800 tracking-tight">IHSAN-LIB</span>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="#layanan" class="text-gray-500 hover:text-green-600 font-medium transition">Layanan</a>
                    <a href="#koleksi" class="text-gray-500 hover:text-green-600 font-medium transition">Koleksi</a>
                    <a href="#tentang" class="text-gray-500 hover:text-green-600 font-medium transition">Tentang Kami</a>
                    <a href="http://opac.ibs.sch.id" target="_blank" class="text-gray-500 hover:text-green-600 font-medium transition">OPAC Eksternal</a>
                </div>
                <div class="hidden md:flex items-center gap-4">
                    <a href="{{ route('portal.index') }}" class="text-gray-500 hover:text-green-600 font-medium mr-4">Area Anggota</a>
                    <button onclick="openStaffModal()" class="bg-green-600 text-white px-5 py-2 rounded-full text-sm font-medium hover:bg-green-700 transition shadow-md border border-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Login Staff</button>
                </div>
                
                <!-- Mobile menu button -->
                <div class="-mr-2 flex md:hidden">
                    <button type="button" id="mobile-menu-button" class="bg-white inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-500" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <!-- Icon when menu is closed. -->
                        <svg id="icon-menu-open" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <!-- Icon when menu is open. -->
                        <svg id="icon-menu-close" class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div class="hidden md:hidden bg-white border-t border-gray-200" id="mobile-menu">
            <div class="pt-2 pb-3 space-y-1">
                <a href="#layanan" class="mobile-link block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">Layanan</a>
                <a href="#koleksi" class="mobile-link block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">Koleksi</a>
                <a href="#tentang" class="mobile-link block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">Tentang Kami</a>
                <a href="http://opac.ibs.sch.id" target="_blank" class="mobile-link block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">OPAC Eksternal</a>
                <a href="{{ route('portal.index') }}" class="mobile-link block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">Area Anggota</a>
            </div>
            <div class="pt-4 pb-4 border-t border-gray-200">
                <div class="flex items-center px-4">
                     <button onclick="openStaffModal()" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Login Staff
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-white transform translate-x-1/2" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                    <polygon points="50,0 100,0 50,100 0,100" />
                </svg>

                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                            <span class="block xl:inline">Pusat Literasi &</span>
                            <span class="block text-green-600 xl:inline">Informasi Digital</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Selamat datang di IHSAN-LIB, perpustakaan modern Al-Ihsan Boarding School. Kami menyediakan akses ke ribuan koleksi fisik dan digital untuk mendukung pembelajaran santri dan guru.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start gap-3">
                            <div class="rounded-md shadow">
                                <a href="{{ route('portal.index') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 md:py-4 md:text-lg md:px-10">
                                    Masuk ke Portal
                                </a>
                            </div>
                            <div class="mt-3 sm:mt-0 sm:ml-3">
                                <a href="#koleksi" class="w-full flex items-center justify-center px-8 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10">
                                    Lihat Koleksi
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" alt="Library">
        </div>
    </div>

    <!-- Features / Layanan -->
    <div id="layanan" class="py-12 bg-white scroll-mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-green-600 font-semibold tracking-wide uppercase">Layanan</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Lebih dari sekadar buku
                </p>
            </div>

            <div class="mt-10">
                <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                    <div class="relative">
                        <dt>
                            <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-green-500 text-white">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                            </div>
                            <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Akses Digital 24/7</p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-500">
                             Akses katalog dan e-book santri dapat dilakukan kapan saja dan di mana saja melalui Portal Anggota IHSAN-LIB.
                        </dd>
                    </div>

                    <div class="relative">
                        <dt>
                            <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-green-500 text-white">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Sirkulasi Mandiri (RFID)</p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-500">
                            Peminjaman dan pengembalian buku lebih cepat dan mudah menggunakan teknologi RFID pada "Kiosk Station" kami.
                        </dd>
                    </div>

                    <div class="relative">
                         <dt>
                            <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-green-500 text-white">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Koleksi Terkurasi</p>
                        </dt>
                         <dd class="mt-2 ml-16 text-base text-gray-500">
                            Ribuan judul buku fisik mulai dari literatur Islam, sains, teknologi, hingga fiksi tersedia untuk Anda pinjam.
                        </dd>
                    </div>

                    <div class="relative">
                         <dt>
                            <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-green-500 text-white">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Area Baca Nyaman</p>
                        </dt>
                         <dd class="mt-2 ml-16 text-base text-gray-500">
                             Ruang baca yang nyaman dan kondusif untuk kegiatan belajar mandiri maupun diskusi santri.
                        </dd>
                    </div>

                </dl>
            </div>
        </div>
    </div>

    <!-- Collection Preview -->
    <div id="koleksi" class="py-16 bg-gray-50 scroll-mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
             <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900">Jelajahi Koleksi Kami</h2>
                <p class="mt-4 text-lg text-gray-500">Temukan buku-buku terbaru yang memperkaya wawasan Anda.</p>
            </div>
            @if(isset($books) && $books->count() > 0)
            <div class="bg-white shadow overflow-hidden sm:rounded-lg max-w-5xl mx-auto border border-gray-200">
                <ul class="divide-y divide-gray-200">
                    @foreach($books as $book)
                    <li>
                        <div class="px-4 py-4 sm:px-6 hover:bg-gray-50 transition duration-150 ease-in-out">
                            <div class="flex items-center justify-between">
                                <div class="flex-1 min-w-0 pr-4">
                                    <h4 class="text-lg font-bold text-gray-900 truncate mb-1">{{ $book->title }}</h4>
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                                        <p class="text-sm text-gray-600 flex items-center gap-1">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            {{ $book->author }}
                                        </p>
                                        <p class="text-sm text-gray-500 flex items-center gap-1">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                            {{ $book->publisher ?? '-' }}
                                        </p>
                                    </div>
                                    <div class="flex items-center mt-2 gap-2">
                                        <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-md bg-blue-50 text-blue-700 border border-blue-100">
                                            {{ $book->category ?? 'Umum' }}
                                        </span>
                                        <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-medium rounded-md bg-gray-100 text-gray-600 border border-gray-200">
                                            Rak: {{ $book->shelf_location ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-shrink-0 flex flex-col items-end gap-2">
                                     @if($book->stock > 0)
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Tersedia
                                        </span>
                                     @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Habis
                                        </span>
                                     @endif
                                     <span class="text-xs text-gray-500 font-mono">Stok: {{ $book->stock }}</span>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <p class="text-xl text-gray-500 font-medium">Belum ada buku yang ditambahkan.</p>
                <p class="text-gray-400 mt-2">Silakan cek kembali nanti.</p>
            </div>
            @endif
             <div class="mt-8 text-center">
                <a href="{{ route('portal.index') }}" class="text-blue-600 font-semibold hover:text-blue-800">Lihat Selengkapnya &rarr;</a>
            </div>
        </div>
    </div>

    <!-- About Us -->
    <div id="tentang" class="py-16 bg-white scroll-mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-8 items-center">
                <div>
                     <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Tentang IHSAN-LIB</h2>
                     <p class="mt-4 text-lg text-gray-500 text-justify">
                        IHSAN-LIB adalah sistem informasi dan manajemen perpustakaan digital yang dikembangkan khusus untuk Al-Ihsan Boarding School. Sistem ini hadir sebagai wujud transformasi digital dalam pengelolaan sumber daya literasi di lingkungan pesantren.
                     </p>
                     <p class="mt-4 text-lg text-gray-500 text-justify">
                        Dengan memadukan teknologi RFID untuk sirkulasi yang cepat dan OPAC (Online Public Access Catalog) yang terintegrasi, IHSAN-LIB berkomitmen untuk memberikan pengalaman perpustakaan yang modern, efisien, dan mudah diakses oleh seluruh civitas akademika.
                     </p>
                </div>
                <div class="mt-10 lg:mt-0">
                    <img class="rounded-lg shadow-lg w-full object-cover h-64 md:h-auto" src="https://images.unsplash.com/photo-1568667256549-094345857637?ixlib=rb-1.2.1&auto=format&fit=crop&w=1050&q=80" alt="Library Interior">
                    <div class="mt-6 text-center">
                        <a href="{{ route('self-service.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200">
                            Pendaftaran Mandiri
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <footer class="bg-green-900 text-white py-8 border-t-4 border-yellow-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center">
            <div class="mb-4 md:mb-0">
                <span class="font-bold text-xl tracking-tight">IHSAN-LIB</span>
                <p class="text-green-200 text-sm mt-1">Sistem Perpustakaan Digital Al-Ihsan Boarding School</p>
            </div>
            <div class="text-sm text-green-200">
                &copy; {{ date('Y') }} IHSAN-LIB. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        (function() {
            const idleLimit = 60 * 1000; 
            let idleTimer;
            const resetIdle = () => {
                clearTimeout(idleTimer);
                idleTimer = setTimeout(() => window.location.href = "{{ url('/') }}", idleLimit);
            };
            ['click','mousemove','keypress','touchstart'].forEach(evt => document.addEventListener(evt, resetIdle));
            resetIdle();
        })();
    </script>
    <!-- STAFF GATE MODAL (Purple Theme Match) -->
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
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ rfid_code: code })
            })
            .then(async res => {
                const contentType = res.headers.get("content-type");
                if (contentType && contentType.indexOf("application/json") !== -1) {
                    return res.json();
                } else {
                    // Not JSON? Likely a 419 (CSRF) or 500 (HTML error)
                    const text = await res.text();
                    throw new Error("Server Response (" + res.status + "): " + text.substring(0, 100)); // Show preview
                }
            })
            .then(data => {
                // Removed loadingStaff and inputStaff.disabled as they are not defined in this context
                
                if (data.status === 'success') {
                    // Redirect to login page with pre-filled email
                    window.location.href = data.redirect + '?email=' + encodeURIComponent(data.email);
                } else {
                    errorText.innerText = data.message || 'Akses Ditolak.';
                    errorBox.classList.remove('hidden');
                    input.value = '';
                    input.focus();
                }
            })
            .catch(err => {
                console.error(err);
                // Removed loadingStaff and inputStaff.disabled as they are not defined in this context
                // Show the actual error message for debugging
                errorText.innerText = err.message || 'Gagal terhubung ke server.';
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

        // Mobile Menu Toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const iconOpen = document.getElementById('icon-menu-open');
        const iconClose = document.getElementById('icon-menu-close');

        if(mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', () => {
                const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
                mobileMenuButton.setAttribute('aria-expanded', !isExpanded);
                
                if (isExpanded) {
                    mobileMenu.classList.add('hidden');
                    iconOpen.classList.remove('hidden');
                    iconClose.classList.add('hidden');
                } else {
                    mobileMenu.classList.remove('hidden');
                    iconOpen.classList.add('hidden');
                    iconClose.classList.remove('hidden');
                }
            });

            // Close menu when clicking a link
            document.querySelectorAll('.mobile-link').forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.add('hidden');
                    mobileMenuButton.setAttribute('aria-expanded', 'false');
                    iconOpen.classList.remove('hidden');
                    iconClose.classList.add('hidden');
                });
            });
        }

</body>
</html>
