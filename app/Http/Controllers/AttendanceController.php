<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\AttendanceSetting;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|in:hadir,izin,alpha',
            'keterangan' => 'nullable|string',
        ]);

        $setting = AttendanceSetting::first();
        if (!$setting) {
            return back()->withErrors('Jam absensi belum ditentukan admin');
        }

        $now = Carbon::now(); // WIB
        $start = Carbon::createFromTimeString($setting->start_time);
        $end = Carbon::createFromTimeString($setting->end_time);
        $graceEnd = $start->copy()->addMinutes(10);

        if (!$now->between($start, $end)) {
            return back()->withErrors(
                'Absensi dibuka pukul ' .
                $start->format('H:i') . ' - ' . $end->format('H:i')
            );
        }

        $statusDetail = 'hadir';
        if ($now->greaterThan($graceEnd)) {
            $statusDetail = 'terlambat';
        }

        Attendance::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'date' => Carbon::today()->toDateString(),
            ],
            [
                'status' => $request->status,
                'status_detail' => $statusDetail,
                'keterangan' => $request->keterangan,
            ]
        );

        return back()->with('success', 'Absensi berhasil disimpan');
    }
}
