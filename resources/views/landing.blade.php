<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <title>Sistem Absensi | PT Bumi Siak Pusako</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css'])
</head>

<body class="h-full bg-gradient-to-br from-gray-900 via-gray-800 to-black text-white">

    <div class="min-h-screen flex items-center justify-center px-6">

        <div class="w-full max-w-xl text-center">

            <!-- Title -->
            <h1 class="text-4xl font-extrabold tracking-wide text-green-400">
                SISTEM ABSENSI ONLINE
            </h1>

            <p class="mt-4 text-gray-400">
                Sistem absensi digital untuk mendukung operasional dan disiplin kerja
                karyawan di lingkungan industri migas.
            </p>

            <!-- Card -->
            <div class="mt-10 bg-gray-900/90 backdrop-blur-md rounded-xl shadow-2xl p-8 border border-gray-700">

                <div class="flex flex-col gap-4">
                    <a href="/login"
                        class="w-full bg-green-600 hover:bg-green-700 transition py-3 rounded-lg font-semibold">
                        Login
                    </a>

                    <a href="/register"
                        class="w-full border border-yellow-500 text-yellow-400 hover:bg-yellow-500 hover:text-black transition py-3 rounded-lg font-semibold">
                        Registrasi Akun
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <p class="mt-10 text-sm text-gray-500">
                © {{ date('Y') }} PT Bumi Siak Pusako • Sistem Internal
            </p>

        </div>

    </div>

</body>

</html>
