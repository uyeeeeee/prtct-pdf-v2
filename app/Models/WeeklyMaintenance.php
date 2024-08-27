<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyMaintenance extends Model
{
    use HasFactory;

    protected $fillable = ['week_number', 'date_from', 'date_to'];

    protected $casts = [
        'date_from' => 'date',
        'date_to' => 'date',
    ];
    public function priorities()
    {
        return $this->hasMany(Priority::class);
    }
}