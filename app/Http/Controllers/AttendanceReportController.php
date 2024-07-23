<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceReportController extends Controller
{
    public function index()
    {
        return view('attendance_reports.index');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $attendances = Attendance::whereBetween('date', [$startDate, $endDate])
            ->with('employee')
            ->get();

        $summary = [
            'present' => $attendances->where('status', 'present')->count(),
            'late' => $attendances->where('status', 'late')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
        ];

        return view('attendance_reports.report', compact('attendances', 'summary', 'startDate', 'endDate'));
    }
}