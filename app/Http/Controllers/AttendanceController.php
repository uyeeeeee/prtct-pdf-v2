<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DatePeriod;
use DateTime;
use DateInterval;
class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('employee')->get();
        return view('attendances.index', compact('attendances'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('attendances.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'check_in' => 'required',
        ]);

        Attendance::create($request->all());

        return redirect()->route('attendances.index')->with('success', 'Attendance recorded successfully.');
    }

    public function show(Attendance $attendance)
    {
        return view('attendances.show', compact('attendance'));
    }

    public function edit(Attendance $attendance)
    {
        $employees = Employee::all();
        return view('attendances.edit', compact('attendance', 'employees'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'check_in' => 'required',
        ]);

        $attendance->update($request->all());

        return redirect()->route('attendances.index')->with('success', 'Attendance updated successfully.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()->route('attendances.index')->with('success', 'Attendance deleted successfully.');
    }
    public function report(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
    
        $startDate = $request->start_date;
        $endDate = $request->end_date;
    
        $employees = Employee::all();
        $attendanceData = [];
    
        foreach ($employees as $employee) {
            $attendances = Attendance::where('employee_id', $employee->id)
                ->whereBetween('date', [$startDate, $endDate])
                ->get();
    
            $present = 0;
            $late = 0;
            $undertime = 0;
            $absent = 0;
    
            $dateRange = new DatePeriod(new DateTime($startDate), new DateInterval('P1D'), new DateTime($endDate . ' +1 day'));
    
            foreach ($dateRange as $date) {
                $dailyAttendance = $attendances->where('date', $date->format('Y-m-d'))->first();
    
                if ($dailyAttendance) {
                    $checkInTime = Carbon::parse($dailyAttendance->check_in);
                    $checkOutTime = $dailyAttendance->check_out ? Carbon::parse($dailyAttendance->check_out) : null;
    
                    if ($checkInTime->format('H:i:s') > '08:30:00') {
                        $late++;
                    } else {
                        $present++;
                    }
    
                    if ($checkOutTime) {
                        if ($checkOutTime->format('H:i:s') < '17:30:00') {
                            $undertime++;
                        }
                    } else {
                        $undertime++;
                    }
                } else {
                    $absent++;
                }
            }
    
            $attendanceData[$employee->id] = [
                'name' => $employee->name,
                'present' => $present,
                'late' => $late,
                'undertime' => $undertime,
                'absent' => $absent,
            ];
        }
    
        return view('attendances.report', compact('attendanceData', 'startDate', 'endDate'));
    }
}