<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DatePeriod;
use DateTime;
use DateInterval;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendancesExport;
use Barryvdh\DomPDF\Facade\Pdf;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('employee')->orderBy('date', 'desc')->paginate(10);
        return view('attendances.index', compact('attendances'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('attendances.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i|after:check_in',
            'is_absent' => 'boolean',
        ]);

        $attendance = new Attendance();
        $attendance->fill($validatedData);
        
        if ($request->boolean('is_absent')) {
            $attendance->status = 'absent';
        } else {
            if (!empty($validatedData['check_in'])) {
                $attendance->check_in = Carbon::parse($validatedData['date'] . ' ' . $validatedData['check_in']);
            }
            if (!empty($validatedData['check_out'])) {
                $attendance->check_out = Carbon::parse($validatedData['date'] . ' ' . $validatedData['check_out']);
            }
            $attendance->status = $attendance->calculateStatus();
        }

        $attendance->save();

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
        $validatedData = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i|after:check_in',
            'is_absent' => 'boolean',
        ]);

        $attendance->fill($validatedData);

        if ($request->boolean('is_absent')) {
            $attendance->status = 'absent';
        } else {
            if (!empty($validatedData['check_in'])) {
                $attendance->check_in = Carbon::parse($validatedData['date'] . ' ' . $validatedData['check_in']);
            }
            if (!empty($validatedData['check_out'])) {
                $attendance->check_out = Carbon::parse($validatedData['date'] . ' ' . $validatedData['check_out']);
            }
            $attendance->status = $attendance->calculateStatus();
        }

        $attendance->save();

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
    
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
    
        $employees = Employee::all();
        $attendanceData = [];
    
        foreach ($employees as $employee) {
            $attendances = Attendance::where('employee_id', $employee->id)
                ->whereBetween('date', [$startDate, $endDate])
                ->get();
    
            $present = $late = $undertime = $absent = 0;
    
            $dateRange = new DatePeriod($startDate, new DateInterval('P1D'), $endDate->addDay());
    
            foreach ($dateRange as $date) {
                $dailyAttendance = $attendances->where('date', $date->format('Y-m-d'))->first();
    
                if ($dailyAttendance) {
                    $checkInTime = $dailyAttendance->check_in ? Carbon::parse($dailyAttendance->check_in) : null;
                    $checkOutTime = $dailyAttendance->check_out ? Carbon::parse($dailyAttendance->check_out) : null;
    
                    if ($checkInTime && $checkInTime->format('H:i:s') > '08:30:00') {
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

    public function exportExcel()
    {
        return Excel::download(new AttendancesExport, 'Attendances.xlsx');
    }

    public function exportPDF()
    {
        $attendances = Attendance::with('employee')->orderBy('date', 'desc')->get();
        $pdf = Pdf::loadView('attendances.pdf', compact('attendances'));
        return $pdf->download('Attendances.pdf');
    }
}