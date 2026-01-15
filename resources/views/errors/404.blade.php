<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tidak Ditemukan - Ihsan-Lib</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Outfit', sans-serif; } </style>
</head>
<body class="bg-gray-50 flex flex-col items-center justify-center min-h-screen text-center px-4">
    <div class="max-w-md w-full bg-white p-8 rounded-2xl shadow-xl transform hover:scale-[1.02] transition-all duration-300">
        <div class="w-24 h-24 bg-gray-100 text-gray-500 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <h1 class="text-4xl font-extrabold text-gray-800 mb-2">404</h1>
        <h2 class="text-xl font-bold text-gray-700 mb-4">Halaman Tidak Ditemukan</h2>
        <p class="text-gray-500 mb-8 text-sm leading-relaxed">Maaf, halaman yang Anda cari mungkin telah dihapus, dipindahkan, atau tidak tersedia saat ini.</p>
        <a href="{{ url('/') }}" class="inline-flex items-center justify-center w-full px-6 py-3 bg-teal-600 text-white font-bold rounded-xl shadow-lg hover:bg-teal-700 transition focus:outline-none focus:ring-4 focus:ring-teal-200">
            Kembali ke Beranda
        </a>
    </div>
</body>
</html>
