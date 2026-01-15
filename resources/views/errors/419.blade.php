<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesi Kedaluwarsa - Ihsan-Lib</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Outfit', sans-serif; } </style>
</head>
<body class="bg-gray-50 flex flex-col items-center justify-center min-h-screen text-center px-4">
    <div class="max-w-md w-full bg-white p-8 rounded-2xl shadow-xl transform hover:scale-[1.02] transition-all duration-300">
        <div class="w-24 h-24 bg-orange-100 text-orange-500 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <h1 class="text-4xl font-extrabold text-gray-800 mb-2">419</h1>
        <h2 class="text-xl font-bold text-gray-700 mb-4">Sesi Kedaluwarsa</h2>
        <p class="text-gray-500 mb-8 text-sm leading-relaxed">Halaman telah kedaluwarsa karena tidak ada aktivitas. Silakan muat ulang halaman atau login kembali.</p>
        <a href="{{ url('/') }}" class="inline-flex items-center justify-center w-full px-6 py-3 bg-orange-600 text-white font-bold rounded-xl shadow-lg hover:bg-orange-700 transition focus:outline-none focus:ring-4 focus:ring-orange-200">
            Muat Ulang Halaman
        </a>
    </div>
</body>
</html>
