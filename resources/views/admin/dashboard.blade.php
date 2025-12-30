<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-black text-gray-200 min-h-screen">

    {{-- ================= NAVBAR ADMIN ================= --}}
    <nav class="bg-gray-900 border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between h-16 items-center">

                <div class="flex gap-8 items-center">
                    <span class="text-green-400 font-bold text-lg">
                        ADMIN ABSENSI
                    </span>

                    <a href="{{ route('admin.dashboard') }}" class="text-gray-300 hover:text-green-400 transition">
                        Dashboard
                    </a>

                    <a href="{{ route('admin.graph') }}" class="text-gray-300 hover:text-green-400 transition">
                        Grafik
                    </a>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded text-sm font-semibold">
                        Logout
                    </button>
                </form>

            </div>
        </div>
    </nav>

    {{-- ================= HEADER ================= --}}
    <header class="border-b border-gray-800 bg-gray-900/80 backdrop-blur">
        <div class="max-w-7xl mx-auto px-6 py-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-extrabold text-green-400">
                    Dashboard Admin Absensi
                </h1>
                <p class="text-sm text-gray-400">
                    Monitoring Kehadiran Karyawan
                </p>
            </div>

            <div class="text-right">
                <div id="clock" class="text-xl font-semibold text-green-400"></div>
                <div class="text-xs text-gray-500">
                    {{ now()->translatedFormat('l, d F Y') }}
                </div>
            </div>
        </div>
    </header>

    @if (session('success'))
        <div class="bg-green-600/20 border border-green-600 text-green-400 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- ================= CONTENT ================= --}}
    <main class="max-w-7xl mx-auto px-6 py-10 space-y-10">

        {{-- SUMMARY --}}
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6">

            <div class="bg-gray-900 border border-gray-700 rounded-xl p-5 text-center">
                <p class="text-sm text-gray-400">Total User</p>
                <h2 class="text-3xl font-bold text-white">{{ $totalUsers }}</h2>
            </div>

            <div class="bg-gray-900 border border-gray-700 rounded-xl p-5 text-center">
                <p class="text-sm text-gray-400">Hadir</p>
                <h2 class="text-3xl font-bold text-green-400">{{ $hadir }}</h2>
            </div>

            <div class="bg-gray-900 border border-gray-700 rounded-xl p-5 text-center">
                <p class="text-sm text-gray-400">Izin</p>
                <h2 class="text-3xl font-bold text-yellow-400">{{ $izin }}</h2>
            </div>

            <div class="bg-gray-900 border border-gray-700 rounded-xl p-5 text-center">
                <p class="text-sm text-gray-400">Alpha</p>
                <h2 class="text-3xl font-bold text-red-400">{{ $alpha }}</h2>
            </div>

            <div class="bg-gray-900 border border-gray-700 rounded-xl p-5 text-center">
                <p class="text-sm text-gray-400">Terlambat</p>
                <h2 class="text-3xl font-bold text-orange-400">{{ $terlambat }}</h2>
            </div>

        </div>

        {{-- ================= SETTING JAM ABSENSI ================= --}}
        <div class="bg-gray-900 border border-gray-700 rounded-xl p-6 shadow-xl">

            <div class="flex justify-between items-center mb-4">
                <form method="POST" action="{{ route('admin.attendance.reset') }}"
                    onsubmit="return confirm('Yakin reset absensi hari ini? Semua pegawai akan dianggap belum absen!')">
                    @csrf
                    @method('DELETE')

                    <button
                        class="bg-red-600 hover:bg-red-700 transition px-5 py-2 rounded-lg font-semibold text-white text-sm">
                        🔄 Reset Absensi Hari Ini
                    </button>
                </form>

                <h3 class="text-green-400 font-semibold">
                    ⏰ Pengaturan Jam Absensi
                </h3>

                @if ($setting)
                    <span class="text-xs text-gray-400">
                        Berlaku saat ini:
                        <strong class="text-white">
                            {{ $setting->start_time }} - {{ $setting->end_time }}
                        </strong>
                    </span>
                @endif
            </div>

            <form method="POST" action="{{ route('admin.attendance.setting') }}"
                class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                @csrf

                <div>
                    <label class="text-sm text-gray-400">Jam Masuk</label>
                    <input type="time" name="start_time" value="{{ $setting->start_time ?? '' }}" required
                        class="w-full mt-1 rounded-lg bg-gray-800 border border-gray-600 text-white focus:border-green-400 focus:ring-green-400">
                </div>

                <div>
                    <label class="text-sm text-gray-400">Batas Akhir Absensi</label>
                    <input type="time" name="end_time" value="{{ $setting->end_time ?? '' }}" required
                        class="w-full mt-1 rounded-lg bg-gray-800 border border-gray-600 text-white focus:border-green-400 focus:ring-green-400">
                </div>

                <button
                    class="bg-green-600 hover:bg-green-700 transition px-6 py-2 rounded-lg font-semibold text-white">
                    Simpan
                </button>
            </form>
        </div>

        {{-- TABEL --}}
        <div class="bg-gray-900 border border-gray-700 rounded-xl p-6 shadow-xl">
            <h3 class="text-green-400 font-semibold mb-6">
                Detail Absensi Hari Ini
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="border-b border-gray-700 text-gray-400">
                        <tr>
                            <th class="py-3 text-left">Nama</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Jam</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rows as $row)
                            <tr class="border-b border-gray-800 hover:bg-gray-800/40">
                                <td class="py-3">{{ $row['name'] }}</td>
                                <td class="text-gray-400">{{ $row['email'] }}</td>
                                <td class="font-semibold">
                                    @if ($row['status_detail'] === 'terlambat')
                                        <span class="text-orange-400">Terlambat</span>
                                    @elseif($row['status'] === 'hadir')
                                        <span class="text-green-400">Hadir</span>
                                    @elseif($row['status'] === 'izin')
                                        <span class="text-yellow-400">Izin</span>
                                    @else
                                        <span class="text-red-400">Alpha</span>
                                    @endif
                                </td>
                                <td class="text-gray-400">{{ $row['time'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    {{-- JAM --}}
    <script>
        function updateClock() {
            const now = new Date();
            document.getElementById('clock').innerText =
                now.toLocaleTimeString('id-ID', {
                    hour12: false
                });
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>

</body>

</html>
