<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use App\Models\AttendanceSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * ============================
     * DASHBOARD ADMIN
     * ============================
     */
    public function index()
    {
        $today = Carbon::today();

        // TOTAL USER
        $totalUsers = User::where('role', 'user')->count();

        // TOTAL ABSENSI HARI INI
        $totalAttendanceToday = Attendance::whereDate('date', $today)->count();

        // IZIN
        $izin = Attendance::whereDate('date', $today)
            ->where('status', 'izin')
            ->count();

        // TERLAMBAT (HADIR + STATUS DETAIL)
        $terlambat = Attendance::whereDate('date', $today)
            ->where('status', 'hadir')
            ->where('status_detail', 'terlambat')
            ->count();

        // HADIR NORMAL (HADIR TAPI TIDAK TERLAMBAT)
        $hadir = Attendance::whereDate('date', $today)
            ->where('status', 'hadir')
            ->where(function ($q) {
                $q->whereNull('status_detail')
                    ->orWhere('status_detail', '!=', 'terlambat');
            })
            ->count();

        // ALPHA = USER TANPA ABSENSI
        $alpha = $totalUsers - $totalAttendanceToday;

        // ============================
        // DATA TABEL DETAIL
        // ============================
        $users = User::where('role', 'user')->get();
        $attendances = Attendance::whereDate('date', $today)
            ->get()
            ->keyBy('user_id');

        $rows = [];

        foreach ($users as $user) {
            $att = $attendances->get($user->id);

            $rows[] = [
                'name'          => $user->name,
                'email'         => $user->email,
                'status'        => $att?->status ?? 'alpha',
                'status_detail' => $att?->status_detail,
                'time'          => $att
                    ? Carbon::parse($att->created_at)->format('H:i')
                    : '-',
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

    /**
     * ============================
     * UPDATE JAM ABSENSI
     * ============================
     */
    public function updateSetting(Request $request)
    {
        $request->validate([
            'start_time' => 'required',
            'end_time'   => 'required|after:start_time',
        ]);

        AttendanceSetting::updateOrCreate(
            ['id' => 1],
            [
                'start_time' => $request->start_time,
                'end_time'   => $request->end_time,
            ]
        );

        return back()->with('success', 'Jam absensi berhasil diperbarui');
    }

    public function reset()
    {
        Attendance::whereDate('date', now()->toDateString())->delete();

        return back()->with('success', 'Absensi hari ini berhasil direset.');
    }

    /**
     * ============================
     * GRAPH STATISTIK
     * ============================
     */
    public function graph()
    {
        $startMonth = Carbon::now()->startOfMonth();
        $endMonth   = Carbon::now()->endOfMonth();

        $totalUsers = User::where('role', 'user')->count();

        $attendances = Attendance::whereBetween('date', [$startMonth, $endMonth])
            ->get()
            ->groupBy(function ($item) {
                return ceil(Carbon::parse($item->date)->day / 5);
            });

        $labels = [];
        $barData = [
            'hadir'     => [],
            'izin'      => [],
            'alpha'     => [],
            'terlambat' => []
        ];

        $pieData = [
            'hadir'     => 0,
            'izin'      => 0,
            'alpha'     => 0,
            'terlambat' => 0
        ];

        foreach ($attendances as $group => $items) {

            $startDay = (($group - 1) * 5) + 1;
            $endDay   = min($group * 5, $endMonth->day);

            $labels[] = "Hari $startDay - $endDay";

            $izin = $items->where('status', 'izin')->count();

            $terlambat = $items->where('status', 'hadir')
                ->where('status_detail', 'terlambat')
                ->count();

            $hadir = $items->where('status', 'hadir')
                ->where('status_detail', '!=', 'terlambat')
                ->count();

            $alpha = $totalUsers - $items->count();

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
