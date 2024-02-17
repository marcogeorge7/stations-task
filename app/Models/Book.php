<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

    protected $fillable = [
        'user_id',
        'trip_id',
        'start',
        'end',
        'seat_number',
    ];


    public function startStation()
    {
        return $this->belongsTo(TripStation::class, 'start', 'id');
    }

    public function endStation()
    {
        return $this->belongsTo(TripStation::class, 'end', 'id');
    }

}
