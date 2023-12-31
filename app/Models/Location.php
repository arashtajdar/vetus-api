<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    // Define the relationship with location images
    public function locationImages()
    {
        return $this->hasMany(LocationImage::class, 'location_id', 'location_id');
    }

    // Define the relationship with reviews
    public function reviews()
    {
        return $this->hasMany(Review::class, 'location_id', 'location_id');
    }

    // Define the relationship with favorites
    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'location_id', 'location_id');
    }

    // Define the relationship with suggestions
    public function suggestions()
    {
        return $this->hasMany(Suggestion::class, 'location_id', 'location_id');
    }
}
