<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Define the relationship with locations
    public function locations()
    {
        return $this->hasMany(Location::class, 'category_id', 'category_id');
    }
}
