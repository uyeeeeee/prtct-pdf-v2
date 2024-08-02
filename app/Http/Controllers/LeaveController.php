<?php

namespace App\Http\Controllers;


use App\Models\Leave;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LeavesExport;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;

class LeaveController extends Controller
{
    public function index()
    {
        $leaves = Leave::with('employee')->get();
        return view('leaves.index', compact('leaves'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('leaves.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
        ]);

        Leave::create($validated);

        return redirect()->route('leaves.index')->with('success', 'Leave added successfully');
    }
    public function show($id)
    {
        $leave = Leave::with('employee')->findOrFail($id);
        return view('leaves.show', compact('leave'));
    }

    // Function to update an existing leave record
    public function edit($id)
    {
        $leave = Leave::findOrFail($id);
        $employees = Employee::all();
        return view('leaves.edit', compact('leave', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
        ]);

        $leave = Leave::findOrFail($id);
        $leave->update($validated);

        return redirect()->route('leaves.index')->with('success', 'Leave updated successfully');
    }

    public function exportExcel()
    {
        return Excel::download(new LeavesExport, 'leaves.xlsx');
    }

    public function exportPdf()
    {
        $leaves = Leave::with('employee')->get();
        
        $html = View::make('leaves.pdf', compact('leaves'))->render();
        
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        
        return $dompdf->stream('leaves.pdf');
    }
}