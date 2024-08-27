<?php

namespace App\Http\Controllers;

use App\Models\Priority;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Models\WeeklyMaintenance;

class PriorityController extends Controller
{
    public function index()
    {
        $priorities = Priority::with(['team', 'weeklyMaintenance'])->get();
        $teams = Team::all();
        $weeklyMaintenances = WeeklyMaintenance::all();
        return view('priorities.index', compact('priorities', 'teams', 'weeklyMaintenances'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'timeline' => 'required|date',
            'green' => 'nullable',
            'yellow' => 'nullable',
            'red' => 'nullable',
            'status' => 'required',
            'team_id' => 'required|exists:teams,id',
            'weekly_maintenance_id' => 'nullable|exists:weekly_maintenances,id',
        ]);

        Priority::create($request->all());

        return redirect()->route('priorities.index')->with('success', 'Priority created successfully.');
    }
    public function edit(Priority $priority)
    {
        $teams = Team::all();
        $weeklyMaintenances = WeeklyMaintenance::all();
        return view('priorities.edit', compact('priority', 'teams', 'weeklyMaintenances'));
    }

    public function update(Request $request, Priority $priority)
    {
        $request->validate([
            'description' => 'required',
            'timeline' => 'required|date',
            'green' => 'nullable',
            'yellow' => 'nullable',
            'red' => 'nullable',
            'status' => 'required',
            'team_id' => 'required|exists:teams,id',
            'weekly_maintenance_id' => 'nullable|exists:weekly_maintenances,id',
        ]);

        $priority->update($request->all());

        return redirect()->route('priorities.index')->with('success', 'Priority updated successfully.');
    }

    public function destroy(Priority $priority)
    {
        $priority->delete();
        return redirect()->route('priorities.index')->with('success', 'Priority deleted successfully.');
    }
}