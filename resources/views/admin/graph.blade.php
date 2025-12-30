<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Absensi</title>

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

                <a href="{{ route('admin.dashboard') }}"
                   class="text-gray-300 hover:text-green-400 transition">
                    Dashboard
                </a>

                <a href="{{ route('admin.graph') }}"
                   class="text-green-400 font-semibold">
                    Grafik
                </a>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded text-sm font-semibold">
                    Logout
                </button>
            </form>

        </div>
    </div>
</nav>

{{-- ================= HEADER ================= --}}
<header class="border-b border-gray-800 bg-gray-900/80 backdrop-blur">
    <div class="max-w-7xl mx-auto px-6 py-6">
        <h1 class="text-2xl font-extrabold text-green-400">
            Grafik Absensi
        </h1>
        <p class="text-sm text-gray-400">
            Visualisasi Kehadiran Karyawan
        </p>
    </div>
</header>

{{-- ================= CONTENT ================= --}}
<main class="max-w-7xl mx-auto px-6 py-10">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

        <div class="bg-gray-900/90 border border-gray-700 rounded-xl p-6 shadow-xl">
            <h3 class="text-green-400 font-semibold mb-4">
                Grafik Batang
            </h3>
            <canvas id="barChart"></canvas>
        </div>

        <div class="bg-gray-900/90 border border-gray-700 rounded-xl p-6 shadow-xl">
            <h3 class="text-green-400 font-semibold mb-4">
                Grafik Lingkaran
            </h3>
            <canvas id="pieChart"></canvas>
        </div>

    </div>

</main>

{{-- ================= SCRIPT ================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const labels = @json($labels);
const barData = @json($barData);
const pieData = @json($pieData);

// BAR CHART (PER 5 HARI)
new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Hadir',
                data: barData.hadir,
                backgroundColor: '#22c55e'
            },
            {
                label: 'Izin',
                data: barData.izin,
                backgroundColor: '#facc15'
            },
            {
                label: 'Alpha',
                data: barData.alpha,
                backgroundColor: '#ef4444'
            },
            {
                label: 'Terlambat',
                data: barData.terlambat,
                backgroundColor: '#fb923c'
            }
        ]
    }
});

// PIE CHART (TOTAL 1 BULAN)
new Chart(document.getElementById('pieChart'), {
    type: 'pie',
    data: {
        labels: ['Hadir', 'Izin', 'Alpha', 'Terlambat'],
        datasets: [{
            data: [
                pieData.hadir,
                pieData.izin,
                pieData.alpha,
                pieData.terlambat
            ],
            backgroundColor: ['#22c55e', '#facc15', '#ef4444', '#fb923c']
        }]
    }
});
</script>
</body>
</html>
