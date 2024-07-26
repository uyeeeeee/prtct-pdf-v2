<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees',
            'phone' => 'required|string|max:20',
            'position' => 'required|string|max:255',
            'work_start_time' => 'required|date_format:H:i',
            'work_end_time' => 'required|date_format:H:i|after:work_start_time',
            'grace_period_minutes' => 'required|integer|min:0',
        ]);
    
        Employee::create($validatedData);
    
        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:employees,email,' . $employee->id,
        'phone' => 'required|string|max:20',
        'position' => 'required|string|max:255',
        'work_start_time' => 'required|date_format:H:i',
        'work_end_time' => 'required|date_format:H:i|after:work_start_time',
        'grace_period_minutes' => 'required|integer|min:0',
    ]);

    $employee->update($validatedData);

    return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
}

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}