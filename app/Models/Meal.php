<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    /**
     * The meals that belong to the restaurant.
     */
    public function restaurants()
    {
        return $this->belongsToMany('App\Models\Restaurant', 'restaurant_meal');
    }
}
