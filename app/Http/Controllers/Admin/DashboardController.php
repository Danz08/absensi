<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\AttendanceSetting;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $totalUsers = User::where('role', 'user')->count();
        $hadir = Attendance::whereDate('date', $today)->where('status', 'hadir')->count();
        $izin  = Attendance::whereDate('date', $today)->where('status', 'izin')->count();
        $alpha = Attendance::whereDate('date', $today)->where('status', 'alpha')->count();
        $terlambat = Attendance::whereDate('date', $today)
            ->where('status_detail', 'terlambat')
            ->count();

        $users = User::where('role', 'user')->get();
        $attendances = Attendance::whereDate('date', $today)->get()->keyBy('user_id');

        $rows = [];
        foreach ($users as $user) {
            $att = $attendances[$user->id] ?? null;

            $rows[] = [
                'name' => $user->name,
                'email' => $user->email,
                'status' => $att->status ?? 'alpha',
                'status_detail' => $att->status_detail ?? null,
                'time' => $att ? Carbon::parse($att->created_at)->format('H:i') : '-',
            ];
        }

        $setting = AttendanceSetting::first();

        return view('admin.dashboard', compact(
            'totalUsers',
            'hadir',
            'izin',
            'alpha',
            'terlambat',
            'rows',
            'setting'
        ));
    }

    public function updateSetting(Request $request)
    {
        $request->validate([
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        AttendanceSetting::updateOrCreate(
            ['id' => 1],
            $request->only('start_time', 'end_time')
        );

        return back()->with('success', 'Jam absensi diperbarui');
    }

   public function graph()
{
    $startMonth = Carbon::now()->startOfMonth();
    $endMonth   = Carbon::now()->endOfMonth();

    // Ambil absensi bulan ini
    $attendances = Attendance::whereBetween('date', [$startMonth, $endMonth])
        ->get()
        ->groupBy(function ($item) {
            // Kelompokkan per 5 hari
            return ceil(Carbon::parse($item->date)->day / 5);
        });

    $labels = [];
    $barData = [
        'hadir' => [],
        'izin' => [],
        'alpha' => [],
        'terlambat' => []
    ];

    $pieData = [
        'hadir' => 0,
        'izin' => 0,
        'alpha' => 0,
        'terlambat' => 0
    ];

    foreach ($attendances as $group => $items) {

        $startDay = (($group - 1) * 5) + 1;
        $endDay   = min($group * 5, $endMonth->day);

        $labels[] = "Hari $startDay - $endDay";

        $hadir = $items->where('status', 'hadir')->count();
        $izin  = $items->where('status', 'izin')->count();
        $alpha = $items->where('status', 'alpha')->count();
        $terlambat = $items->where('status_detail', 'terlambat')->count();

        $barData['hadir'][] = $hadir;
        $barData['izin'][] = $izin;
        $barData['alpha'][] = $alpha;
        $barData['terlambat'][] = $terlambat;

        $pieData['hadir'] += $hadir;
        $pieData['izin'] += $izin;
        $pieData['alpha'] += $alpha;
        $pieData['terlambat'] += $terlambat;
    }

    return view('admin.graph', compact(
        'labels',
        'barData',
        'pieData'
    ));
}
}
