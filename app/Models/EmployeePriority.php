<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePriority extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'timeline', 'green', 'yellow', 'red', 'status', 'employee_id', 'weekly_maintenance_id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function weeklyMaintenance()
    {
        return $this->belongsTo(WeeklyMaintenance::class);
    }
}