<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripStation extends Model
{
    protected $fillable = [
        'station_id',
        'trip_id',
        'stage',
        'reach_time',
    ];

    protected $casts = [
        'reach_time' => 'datetime:Y-m-d H:00'
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function destination()
    {
        return $this->hasMany(TripStation::class, 'trip_id', 'trip_id');
    }
}
