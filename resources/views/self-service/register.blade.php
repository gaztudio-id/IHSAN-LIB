<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Mandiri Santri - IHSAN-LIB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen py-10 px-4">

<div class="max-w-4xl mx-auto mt-10">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="p-8 md:p-12">
            <div class="text-center mb-8">
                <img src="{{ asset('logo_ibs.png') }}" alt="Logo IBS" class="h-16 w-auto mx-auto mb-4 object-contain">
                <h1 class="text-3xl font-extrabold text-green-700">Pendaftaran Anggota Baru</h1>
                <p class="text-gray-500 mt-2">Silakan tempelkan kartu RFID Anda pada alat scan.</p>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <a href="{{ url('/') }}" class="absolute top-6 left-6 text-gray-400 hover:text-green-600 bg-white p-2 rounded-full shadow-sm hover:shadow transition" title="Kembali ke Cover">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>

            <!-- Step 1: Scan (Click to Activate) -->
            <div id="scan-section" class="flex flex-col items-center justify-center py-10">
                <!-- Green Fingerprint Button (Activates Scanner) -->
                <button id="activate-scan-btn" class="group relative w-48 h-48 mx-auto bg-green-50 rounded-full flex items-center justify-center mb-8 transition-all duration-300 hover:bg-green-100 hover:scale-105 active:scale-95 focus:outline-none focus:ring-4 focus:ring-green-200">
                     <div id="scan-pulse" class="absolute inset-0 bg-green-400 rounded-full opacity-0 transition-opacity duration-300"></div>
                    <!-- Fingerprint Icon -->
                    <svg class="w-24 h-24 text-green-600 group-hover:text-green-700 transition-colors z-10" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.2-2.848.578-4.137m.087-2.67C5.32 2.68 7.352 1.5 10 1.5c2.648 0 4.68 1.18 5.335 2.687"></path>
                    </svg>
                </button>
                
                <p id="scan-instruction" class="text-xl font-semibold text-gray-700">Klik ikon di atas untuk <span class="font-bold text-green-600">SCAN KARTU</span></p>
                
                <!-- Hidden Input -->
                <input type="text" id="rfid-input" class="opacity-0 absolute top-0 left-0 w-full h-full -z-10" autocomplete="off">
            </div>

            <!-- ... (Step 2 and rest remain same) ... -->

<script>
    const rfidInput = document.getElementById('rfid-input');
    const scanSection = document.getElementById('scan-section');
    const formSection = document.getElementById('form-section');
    const loadingSection = document.getElementById('loading-section');
    const errorMessage = document.getElementById('error-message');
    const detectedRfid = document.getElementById('detected-rfid-code');
    const formRfid = document.getElementById('form-rfid');
    const scanBtn = document.getElementById('activate-scan-btn');

    // Activate Scanner Logic
    const activateScanner = () => {
        const pulse = document.getElementById('scan-pulse');
        const instr = document.getElementById('scan-instruction');
        const notif = document.getElementById('error-message');
        const notifText = document.getElementById('error-text');
        
        if(rfidInput) {
             rfidInput.value = '';
             rfidInput.focus();
             
             if(pulse) pulse.classList.add('animate-ping', 'opacity-30');
             const originalText = instr ? instr.innerHTML : '';
             if(instr) instr.innerHTML = '<span class="text-green-600 font-bold animate-pulse">SILAKAN TEMPEL KARTU...</span>';
             
             // Aggressive Focus
             const focuser = setInterval(() => { rfidInput.focus(); }, 100);
             
             // TIMEOUT (8 Sec)
             setTimeout(() => { 
                 clearInterval(focuser); 
                 if(pulse) pulse.classList.remove('animate-ping', 'opacity-30');
                 if(instr) instr.innerHTML = originalText;
                 
                 // If Empty -> Show Error
                 if(rfidInput.value.trim() === '') {
                     if(notif) {
                         notif.classList.remove('hidden');
                         if(notifText) notifText.innerText = "Waktu pemindaian habis. Klik tombol untuk memindai lagi.";
                         setTimeout(() => notif.classList.add('hidden'), 4000);
                     }
                 }
             }, 8000);
        }
    };
    
    if(scanBtn) {
        scanBtn.addEventListener('click', activateScanner);
    }

    let inputBuffer = '';
    let lastKeyTime = Date.now();

    rfidInput.addEventListener('keydown', (e) => {
        const currentTime = Date.now();
        
        if (e.key === 'Enter') {
            if (inputBuffer.length > 3) {
                checkRfid(inputBuffer);
            }
            inputBuffer = '';
        } else {
            if (currentTime - lastKeyTime > 100) inputBuffer = '';
            inputBuffer += e.key;
        }
        lastKeyTime = currentTime;
    });

    function checkRfid(code) {
        scanSection.classList.add('hidden');
        loadingSection.classList.remove('hidden');
        errorMessage.classList.add('hidden');

        // Check availability via API
        fetch(`{{ route('self-service.check') }}?code=${code}`)
            .then(res => res.json())
            .then(data => {
                loadingSection.classList.add('hidden');
                if (data.exists) {
                    errorMessage.classList.remove('hidden');
                    document.getElementById('error-text').innerText = "Kartu ini sudah terdaftar atas nama: " + data.member.name;
                    scanSection.classList.remove('hidden');
                } else {
                    // New Card
                    formSection.classList.remove('hidden');
                    detectedRfid.innerText = "CODE: " + code;
                    formRfid.value = code;
                    document.getElementById('name').focus();
                }
            })
            .catch(err => {
                console.error(err);
                loadingSection.classList.add('hidden');
                scanSection.classList.remove('hidden');
                alert('Gagal memeriksa kartu. Coba lagi.');
            });
    }
</script>
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
