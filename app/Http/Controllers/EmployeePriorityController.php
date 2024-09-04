<?php

namespace App\Http\Controllers;

use App\Models\EmployeePriority;
use App\Models\Employee;
use App\Models\WeeklyMaintenance;
use Illuminate\Http\Request;

class EmployeePriorityController extends Controller
{
    public function index()
    {
        $priorities = EmployeePriority::all();
        $employees = Employee::all();
        $weeklyMaintenances = WeeklyMaintenance::all();
        return view('employee-priorities.index', compact('priorities', 'employees', 'weeklyMaintenances'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string',
            'timeline' => 'required|date',
            'green' => 'nullable|string',
            'yellow' => 'nullable|string',
            'red' => 'nullable|string',
            'status' => 'required|string',
            'employee_id' => 'required|exists:employees,id',
            'weekly_maintenance_id' => 'nullable|exists:weekly_maintenances,id',
        ]);

        EmployeePriority::create($validated);

        return redirect()->route('employee-priorities.index')->with('success', 'Priority added successfully');
    }

    public function update(Request $request, EmployeePriority $employeePriority)
    {
        $validated = $request->validate([
            'description' => 'required|string',
            'timeline' => 'required|date',
            'green' => 'nullable|string',
            'yellow' => 'nullable|string',
            'red' => 'nullable|string',
            'status' => 'required|string',
            'employee_id' => 'required|exists:employees,id',
            'weekly_maintenance_id' => 'nullable|exists:weekly_maintenances,id',
        ]);

        $employeePriority->update($validated);

        return redirect()->route('employee-priorities.index')->with('success', 'Priority updated successfully');
    }

    public function destroy(EmployeePriority $employeePriority)
    {
        $employeePriority->delete();

        return redirect()->route('employee-priorities.index')->with('success', 'Priority deleted successfully');
    }
}