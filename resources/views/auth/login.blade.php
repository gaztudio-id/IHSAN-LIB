<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Staff & Admin - IHSAN-LIB</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-lg shadow-lg max-w-sm w-full relative">
        <a href="{{ url('/') }}" class="absolute top-4 left-4 text-gray-400 hover:text-green-600 transition" title="Kembali">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div class="text-center mb-6">
            <img src="{{ asset('logo_ibs.png') }}" alt="Logo IBS" class="h-16 w-auto mx-auto mb-4 object-contain">
            <h1 class="text-2xl font-bold text-green-600">IHSAN-LIB</h1>
            <p class="text-gray-500 text-sm">Masuk sebagai Staff atau Admin</p>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif



        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                <input type="email" name="email" id="email" value="{{ request('email') ?? old('email') }}" class="shadow appearance-none border border-green-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-green-500 focus:border-green-500" required autofocus>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" id="password" class="shadow appearance-none border border-green-200 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:ring-green-500 focus:border-green-500" required>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full transition duration-300">
                    Sign In
                </button>
            </div>
        </form>
        
        <div class="mt-6 text-center text-xs text-gray-500">
            &copy; 2025 IHSAN-LIB. All rights reserved.
        </div>
    </div>

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
</body>
</html>
