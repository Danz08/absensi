<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sistem Absensi | PT Bumi Siak Pusako</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-gray-950 via-gray-900 to-black text-gray-300">

    <!-- BACK BUTTON -->
    <div class="absolute top-6 left-6">
        <a href="/"
           class="px-4 py-2 border border-gray-700 rounded-md text-sm text-gray-400
                  hover:text-green-400 hover:border-green-500 transition">
            ← Kembali
        </a>
    </div>

    <div class="min-h-screen flex items-center justify-center px-6">

        <div class="w-full max-w-md">

            <!-- BRAND -->
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4 opacity-80">
                    <x-application-logo class="w-20 h-20 fill-current text-green-500" />
                </div>

                <h1 class="text-2xl font-extrabold tracking-widest text-green-400">
                    SISTEM ABSENSI
                </h1>

                <p class="text-sm tracking-wide text-gray-400 mt-1">
                    PT BUMI SIAK PUSAKO
                </p>
            </div>

            <!-- AUTH CARD -->
            <div
                class="bg-gray-900/90 backdrop-blur border border-gray-700
                       rounded-2xl shadow-2xl px-8 py-8">

                {{-- SLOT FORM LOGIN / REGISTER --}}
                {{ $slot }}

            </div>

            <!-- FOOTER -->
            <p class="text-center text-xs text-gray-500 mt-6">
                © {{ date('Y') }} PT Bumi Siak Pusako • Sistem Internal Migas
            </p>

        </div>
    </div>

</body>
</html>
