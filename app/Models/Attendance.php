<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'date',
        'check_in',
        'check_out',
        'status',
        'is_absent'
    ];

    protected $casts = [
        'date' => 'date',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'is_absent' => 'boolean'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function calculateStatus()
    {
        if ($this->is_absent) {
            return 'absent';
        }

        if (!$this->check_in) {
            return null;
        }

        $employee = $this->employee;
        $workStartTime = Carbon::parse($this->date->format('Y-m-d') . ' ' . $employee->work_start_time->format('H:i:s'));
        $gracePeriod = $employee->grace_period_minutes;
        $lateThreshold = $workStartTime->copy()->addMinutes($gracePeriod);

        if ($this->check_in->lte($lateThreshold)) {
            return 'present';
        } else {
            return 'late';
        }
    }
}