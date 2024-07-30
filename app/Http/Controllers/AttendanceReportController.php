<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\Employee;
use Carbon\Carbon;
use App\Exports\AttendanceReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

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
               
                'missing' => $missingDates->count(),
            ];
        }

        $summary = [
            'total_employees' => $employees->count(),
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
        ];
        session([
            'report_data' => $reportData,
            'report_summary' => $summary
        ]);
        return view('attendance_reports.report', compact('reportData', 'summary', 'startDate', 'endDate'));
    }
    public function export() 
{
    $reportData = session('report_data', []);
    $summary = session('report_summary', []);

    $startDate = $summary['start_date'] ?? 'N/A';
    $endDate = $summary['end_date'] ?? 'N/A';
    $totalEmployees = $summary['total_employees'] ?? 'N/A';


    // Add summary information at the top of the sheet
    $exportData = [
        ['Attendance Report'],
        ['Period:', $summary['start_date'] . ' to ' . $summary['end_date']],
        ['Total Employees:', $summary['total_employees']],
        [], // Empty row for spacing
        ['Employee Name', 'Present', 'Late', 'Absent']
    ];

    // Add the actual report data
    $exportData = array_merge($exportData, $reportData);

    return Excel::download(new AttendanceReportExport($exportData), 'attendance_report.xlsx');
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

    public function generatePDF()
    {
        $reportData = session('report_data', []);
        $summary = session('report_summary', []);

        $startDate = $summary['start_date'] ?? 'N/A';
        $endDate = $summary['end_date'] ?? 'N/A';
        $totalEmployees = $summary['total_employees'] ?? 'N/A';

        $pdf = PDF::loadView('attendance_reports.pdf', compact('reportData', 'summary', 'startDate', 'endDate', 'totalEmployees'));

        return $pdf->download('attendance_report.pdf');
    }
}
