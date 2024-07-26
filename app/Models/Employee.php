<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class Employee extends Model
{
    // ...

    protected $fillable = [
        'name', 'email', 'phone', 'position', 'work_start_time', 'work_end_time', 'grace_period_minutes'
    ];

    protected $casts = [
        'work_start_time' => 'datetime',
        'work_end_time' => 'datetime',
    ];
    

    public function attendances()
    {
        
        return $this->hasMany(Attendance::class);
    }
    
}
