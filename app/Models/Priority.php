<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'timeline', 'green', 'yellow', 'red', 'status', 'team_id', 'weekly_maintenance_id'];

  

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
    public function weeklyMaintenance()
    {
        return $this->belongsTo(WeeklyMaintenance::class);
    }
}