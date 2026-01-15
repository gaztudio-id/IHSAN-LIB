<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kesalahan Server - Ihsan-Lib</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Outfit', sans-serif; } </style>
</head>
<body class="bg-gray-50 flex flex-col items-center justify-center min-h-screen text-center px-4">
    <div class="max-w-md w-full bg-white p-8 rounded-2xl shadow-xl transform hover:scale-[1.02] transition-all duration-300">
        <div class="w-24 h-24 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>
        <h1 class="text-4xl font-extrabold text-gray-800 mb-2">500</h1>
        <h2 class="text-xl font-bold text-gray-700 mb-4">Terjadi Kesalahan Server</h2>
        <p class="text-gray-500 mb-8 text-sm leading-relaxed">Maaf, terjadi kesalahan internal pada server kami. Mohon coba beberapa saat lagi.</p>
        <a href="{{ url('/') }}" class="inline-flex items-center justify-center w-full px-6 py-3 bg-red-600 text-white font-bold rounded-xl shadow-lg hover:bg-red-700 transition focus:outline-none focus:ring-4 focus:ring-red-200">
            Kembali ke Beranda
        </a>
    </div>
</body>
</html>
