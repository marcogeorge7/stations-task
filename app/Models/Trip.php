<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'title',
        'seats',
        'start_at',
    ];

    protected $casts = [
        'start_at' => 'datetime:Y-m-d H:00'
    ];

    public function tripStations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TripStation::class);
    }

    public function stations(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(
            Station::class,
            TripStation::class,
            'trip_id',
            'id',
            'id',
            'station_id'
        );
    }
}
