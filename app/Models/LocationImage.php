<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationImage extends Model
{
    use HasFactory;
    // Define the relationship with the location
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'location_id');
    }
}
