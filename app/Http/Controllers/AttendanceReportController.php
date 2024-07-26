<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\Employee;
use Carbon\Carbon;

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

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        $employees = Employee::all();
        $reportData = [];

        foreach ($employees as $employee) {
            $workingDays = $this->getWorkingDays($startDate, $endDate);
            
            $attendances = Attendance::where('employee_id', $employee->id)
                ->whereBetween('date', [$startDate, $endDate])
                ->get();

            $presentDays = $attendances->where('status', 'present')->count();
            $lateDays = $attendances->where('status', 'late')->count();
            $absentDays = $attendances->where('is_absent', true)->count();

            $missingDates = $workingDays->diff($attendances->pluck('date'))->map(function ($date) {
                return $date->toDateString();
            });

            $reportData[$employee->id] = [
                'name' => $employee->name,
                'present' => $presentDays,
                'late' => $lateDays,
                'absent' => $absentDays,
                'missing' => $missingDates->count(),
            ];
        }

        $summary = [
            'total_employees' => $employees->count(),
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
        ];

        return view('attendance_reports.report', compact('reportData', 'summary', 'startDate', 'endDate'));
    }

    private function getWorkingDays($startDate, $endDate)
    {
        $days = collect();
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            if ($date->isWeekday()) {
                $days->push($date->copy());
            }
        }
        return $days;
    }
}
/*use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AttendanceReportController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        $employees = Employee::all();
        $period = CarbonPeriod::create($startDate, $endDate);

        $attendanceData = [];
        $summary = ['present' => 0, 'late' => 0, 'absent' => 0];

        foreach ($employees as $employee) {
            $employeeAttendance = [];
            foreach ($period as $date) {
                if ($date->isWeekend()) {
                    continue; // Skip weekends
                }

                $attendance = Attendance::where('employee_id', $employee->id)
                    ->whereDate('date', $date)
                    ->first();

                if ($attendance) {
                    $status = $attendance->status;
                    $summary[$status]++;
                } else {
                    $status = 'absent';
                    $summary['absent']++;
                }

                $employeeAttendance[] = [
                    'date' => $date->toDateString(),
                    'status' => $status,
                    'check_in' => $attendance ? $attendance->check_in : null,
                ];
            }
            $attendanceData[$employee->id] = $employeeAttendance;
        }

        return view('attendance_reports.report', compact('attendanceData', 'summary', 'startDate', 'endDate', 'employees'));
    }
}*/