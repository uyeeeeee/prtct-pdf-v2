<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'start_date',
        'end_date',
        'reason',
    ];

    protected $dates = ['start_date', 'end_date'];
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
    

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // If you want to ensure dates are always returned as Carbon instances
    public function getStartDateAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }

    public function getEndDateAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }
}