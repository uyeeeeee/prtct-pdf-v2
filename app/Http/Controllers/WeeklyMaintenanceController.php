<?php

namespace App\Http\Controllers;

use App\Models\WeeklyMaintenance;
use Illuminate\Http\Request;

class WeeklyMaintenanceController extends Controller
{
    public function index()
    {
        $weeklyMaintenances = WeeklyMaintenance::all();
        return view('weekly-maintenance.index', compact('weeklyMaintenances'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'week_number' => 'required|integer',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
        ]);

        WeeklyMaintenance::create($request->all());

        return redirect()->route('weekly-maintenance.index')->with('success', 'Weekly maintenance added successfully.');
    }
     
    public function update(Request $request, WeeklyMaintenance $weeklyMaintenance)
{
    $request->validate([
        'week_number' => 'required|integer',
        'date_from' => 'required|date',
        'date_to' => 'required|date|after_or_equal:date_from',
    ]);

    $weeklyMaintenance->update($request->all());

    return redirect()->route('weekly-maintenance.index')->with('success', 'Weekly maintenance updated successfully.');
}

public function destroy(WeeklyMaintenance $weeklyMaintenance)
{
    $weeklyMaintenance->delete();

    return redirect()->route('weekly-maintenance.index')->with('success', 'Weekly maintenance deleted successfully.');
}
}