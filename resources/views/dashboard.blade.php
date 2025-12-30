<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-extrabold tracking-wide text-green-600">
                    Dashboard Absensi
                </h2>
                <p class="text-sm text-gray-500">
                    Kehadiran Karyawan
                </p>
            </div>

            {{-- JAM --}}
            <div class="text-right">
                <div id="clock" class="text-xl font-semibold text-green-600"></div>
                <div class="text-xs text-gray-500">
                    {{ now()->translatedFormat('l, d F Y') }}
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">

        <div class="max-w-6xl mx-auto space-y-8">

            {{-- ALERT --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- SUMMARY --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-gradient-to-r from-green-600 to-green-500 text-white p-6 rounded-xl shadow">
                    <p class="text-sm">Hadir</p>
                    <h3 class="text-3xl font-bold mt-2">{{ $summary['hadir'] }}</h3>
                </div>

                <div class="bg-gradient-to-r from-yellow-400 to-yellow-300 text-black p-6 rounded-xl shadow">
                    <p class="text-sm">Izin</p>
                    <h3 class="text-3xl font-bold mt-2">{{ $summary['izin'] }}</h3>
                </div>

                <div class="bg-gradient-to-r from-red-500 to-red-400 text-white p-6 rounded-xl shadow">
                    <p class="text-sm">Alpha</p>
                    <h3 class="text-3xl font-bold mt-2">{{ $summary['alpha'] }}</h3>
                </div>

            </div>

            {{-- FORM ABSEN --}}
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">

                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    Form Absensi Hari Ini
                </h3>

                <form method="POST" action="{{ route('attendance.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Status Kehadiran
                        </label>
                        <select name="status" required
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                            <option value="hadir">Hadir</option>
                            <option value="izin">Izin</option>
                            <option value="alpha">Alpha</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Keterangan
                        </label>
                        <textarea name="keterangan" rows="3"
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"></textarea>
                    </div>

                    <button
                        class="w-full bg-green-600 hover:bg-green-700 transition text-white font-semibold py-3 rounded-lg">
                        Simpan Absensi
                    </button>
                </form>
            </div>

        </div>
    </div>

    {{-- JAM --}}
    <script>
        function updateClock() {
            const now = new Date();
            document.getElementById('clock').innerText =
                now.toLocaleTimeString('id-ID', { hour12: false });
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</x-app-layout>
